<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
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
            $this->multipleOf($this->error('G', 'VALIDATION', $this->errorMessage), [], 'errors'),
        ];
    }

    protected function mutateSchema(array $definition): array
    {
        foreach ($definition as &$schema) {
            /** @var Schema $schema */
            if ($schema->objectId === 'data') {
                $schema = Schema::object('data')
                    ->additionalProperties(Schema::array()->items(Schema::string()))
                    ->example(['field' => ['The field is required.']]);
            }
        }
        return $definition;
    }
}
