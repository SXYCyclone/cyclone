<?php

namespace Src\Common\Infrastructure\Laravel\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $responseMacros = [
            'success' => function ($data = [], $status = HttpResponse::HTTP_OK, $extraHeaders = []): JsonResponse {
                if ($data instanceof \JsonSerializable) {
                    $data = $data->jsonSerialize();
                }
                $response = [
                    "status" => "success",
                    "data" => $data,
                ];

                return response()->json($response, $status, $extraHeaders);
            },
            'fail' => function ($data, $status = HttpResponse::HTTP_BAD_REQUEST, $extraHeaders = []): JsonResponse {
                $response = [
                    "status" => "fail",
                    "data" => $data,
                ];

                return response()->json($response, $status, $extraHeaders);
            },
            'error' => function ($message, $code = null, $data = null, $status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR, $extraHeaders = []): JsonResponse {
                $response = [
                    "status" => "error",
                    "message" => $message,
                ];
                !is_null($code) && $response['code'] = $code;
                !is_null($data) && $response['data'] = $data;

                return response()->json($response, $status, $extraHeaders);
            },
        ];

        foreach ($responseMacros as $macro => $callback) {
            Response::macro($macro, $callback);
            \Illuminate\Http\Response::macro($macro, $callback);
        }
    }
}
