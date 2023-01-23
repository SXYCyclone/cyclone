<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Jiannei\Response\Laravel\Support\Facades\Response as JianneiResponse;
use Src\Agenda\Company\Domain\Model\Company;
use Tenancy\Identification\Contracts\ResolvesTenants;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving(ResolvesTenants::class, function (ResolvesTenants $resolver) {
            $resolver->addModel(Company::class);
            return $resolver;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $responseMacros = [
            'success' => function (mixed $data = [], $message = '', $code = 200, $headers = [], $option = 0): JsonResponse {
                if ($data instanceof \JsonSerializable) {
                    $data = $data->jsonSerialize();
                }
                if (is_object($data)) {
                    $data = (array)$data;
                }

                return JianneiResponse::success($data, $message, $code, $headers, $option);
            },
            'fail' => function ($message = '', $code = 500, $errors = null, $header = [], $options = 0): JsonResponse {
                return JianneiResponse::fail($message, $code, $errors, $header, $options);
            },
//            'error' => function ($message, $code = null, $data = null, $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR, $extraHeaders = []): JsonResponse {
//                $response = [
//                    "status" => "error",
//                    "message" => $message,
//                ];
//                !is_null($code) && $response['code'] = $code;
//                !is_null($data) && $response['data'] = $data;
//
//                return response()->json($response, $status, $extraHeaders);
//            },
        ];

        foreach ($responseMacros as $macro => $callback) {
            Response::macro($macro, $callback);
            \Illuminate\Http\Response::macro($macro, $callback);
        }
    }
}
