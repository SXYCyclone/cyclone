<?php

namespace Src\Common\Presentation\CLI;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SyncOpenApiSchemaCmd extends Command
{
    protected $signature = 'openapi:sync';

    protected $description = 'Syncs the OpenAPI schema with the code';

    public function handle()
    {
        $modelLocations = config('ide-helper.model_locations');
        // scan the models directory for models
        $models = collect($modelLocations)->flatMap(function ($location) {
            return collect(glob($location . '/*.php'))->map(function ($file) {
                $fqcn = Str::of($file)
                    ->replaceLast('.php', '')
                    ->ucfirst()
                    ->replace('/', '\\')
                    ->toString();
                if (!class_exists($fqcn)) {
                    $this->warn('Class ' . $fqcn . ' does not exist');
                }
                if (!is_subclass_of($fqcn, Model::class)) {
                    $this->warn('Class ' . $fqcn . ' is not a model');
                }
                return $fqcn;
            });
        })->toArray();
        $this->info('Found ' . count($models) . ' models');
        $this->info('Moving models to the staging area');
        $stageDir = app_path('Models');

        // prepare the staging area
        File::ensureDirectoryExists($stageDir);
        File::cleanDirectory($stageDir);

        foreach ($models as $model) {
            // move the model to the staging area
            // turn FQCN to path
            $path = Str::of($model)
                ->replace('\\', '/')
                ->replaceFirst('Src', 'src')
                ->append('.php')
                ->toString();
            $destination = $stageDir . '/' . basename($path);
            if (File::exists($destination)) {
                $this->warn('File ' . $destination . ' already exists');
            }
            File::copy($path, $stageDir . '/' . basename($path));
        }

        $this->info('Generating OpenAPI schema');
        foreach ($models as $model) {
            $domain = Str::of($model)->after('Src\\')->beforeLast('\\Infrastructure')->toString();
            $name = Str::of($model)->afterLast('\\')->replaceLast('EloquentModel', '')->toString();
            $this->info('Generating schema for ' . $name);
            $this->call('openapi:make-schema', [
                'name' => $domain . '/' . $name,
                '--model' => $model,
                '--quiet' => true,
            ]);
        }

        // move schemas to specifications
        $this->info('Moving schemas to specifications');
        $specDir = base_path('specifications/OpenApi/Schemas');
        File::ensureDirectoryExists($specDir);
        File::cleanDirectory($specDir);
        File::moveDirectory(app_path('OpenApi/Schemas'), $specDir);

        // adjust specification's schemas namespace
        $this->info('Adjusting schemas namespace');
        $files = File::allFiles($specDir);
        foreach ($files as $file) {
            $content = File::get($file);
            $content = Str::of($content)
                ->replace('namespace Src\\OpenApi\\', 'namespace Specifications\\OpenApi\\')
                ->toString();
            File::put($file, $content);
        }

        $this->info('Cleaning up');
        File::deleteDirectory($stageDir);
        File::deleteDirectory(app_path('OpenApi'));
    }
}
