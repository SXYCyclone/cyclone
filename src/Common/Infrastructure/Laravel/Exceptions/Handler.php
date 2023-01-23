<?php

namespace Src\Common\Infrastructure\Laravel\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Jiannei\Response\Laravel\Support\Facades\Response;
use Jiannei\Response\Laravel\Support\Traits\ExceptionTrait;
use Src\Common\Domain\Exceptions\DomainException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    use ExceptionTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        $errors = [
            [
                'domain' => 'app.validation',
                'reason' => 'VALIDATION_FAILED',
                'message' => 'The given data was invalid.',
            ],
        ];
        foreach ($exception->errors() as $field => $errs) {
            $errors[] = [
                'domain' => 'app.validation',
                'reason' => 'INVALID_FIELD',
                'location_type' => 'field',
                'location' => $field,
                'message' => $errs[0],
            ];
        }

        return Response::fail(
            'The given data was invalid.',
            Arr::get(Config::get('response.exception'), ValidationException::class . '.code', 422),
            $errors,
        );
    }

    protected function prepareJsonResponse($request, $e)
    {
        // 要求请求头 header 中包含 /json 或 +json，如：Accept:application/json
        // 或者是 ajax 请求，header 中包含 X-Requested-With：XMLHttpRequest;
        $exceptionConfig = Arr::get(Config::get('response.exception'), get_class($e));

        if ($e instanceof HttpExceptionInterface) {
            $code = $e->getStatusCode();
            $header = $e->getHeaders();
        } else {
            $code = 500;
            $header = [];
        }

        $message = $exceptionConfig['message'] ?? $e->getMessage();
        $options = $exceptionConfig['options'] ?? (JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($e instanceof DomainException) {
            $error = [
                'domain' => $e->getDomain(),
                'reason' => $e->getUniqueIdentifier(),
                'message' => $message,
            ];
        } else {
            $error = [
                'domain' => 'app',
                'reason' => 'UNEXPECTED_EXCEPTION',
                'message' => $message,
            ];
        }

        return Response::fail($message, $code, [$error], $header, $options);
    }
}
