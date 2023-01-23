<?php

namespace Src\Common\Presentation\CLI;

use Illuminate\Console\Command;
use Src\Agenda\User\Infrastructure\EloquentModels\UserEloquentModel;
use Tenancy\Facades\Tenancy;

class PlayCmd extends Command
{
    protected $signature = 'play';

    public function handle()
    {
        $this->info('Playing as ' . Tenancy::getTenant()->getTenantKey());
        dd(UserEloquentModel::all()->pluck('name'));
    }
}
