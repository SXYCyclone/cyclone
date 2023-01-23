<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class ErrorAuthenticationResponse extends ResponseFactory implements Reusable
{
    protected ?string $id = 'ErrorAuthentication';

    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;

    protected string $description = 'Authentication error';

    protected string $status = 'fail';

    public function definition(): array
    {
        return [
            Schema::string('error')->example('Unauthorized'),
        ];
    }
}
