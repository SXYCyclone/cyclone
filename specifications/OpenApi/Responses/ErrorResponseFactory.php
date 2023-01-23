<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

abstract class ErrorResponseFactory extends ResponseFactory
{
    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;

    protected string $status = 'error';

    protected string $errorMessage;

    public function definition(): array
    {
        return array_merge([
            Schema::integer('code')->example($this->statusCode),
            Schema::string('message')->example($this->errorMessage),
        ], $this->additionalProperties());
    }

    public function additionalProperties(): array
    {
        return [];
    }
}
