<?php

namespace Specifications\OpenApi\Responses;

use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class ErrorValidationResponse extends ErrorResponseFactory implements Reusable
{
    protected ?string $id = 'ErrorValidation';

    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY;

    protected string $description = 'Validation error';

    protected string $errorMessage = 'The given data was invalid.';

    public function additionalProperties(): array
    {
        return [
            $this->multipleOf($this->error('app.validation', 'INVALID_FAILED', $this->errorMessage), [
                [
                    'domain' => 'app.validation',
                    'reason' => 'VALIDATION_FAILED',
                    'message' => 'The given data was invalid.',
                ],
                [
                    'domain' => 'app.validation',
                    'reason' => 'INVALID_FIELD',
                    'location_type' => 'field',
                    'location' => 'field',
                    'message' => 'The field is invalid.',
                ],
            ], 'errors'),
        ];
    }
}
