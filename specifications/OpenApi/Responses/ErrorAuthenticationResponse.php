<?php

namespace Specifications\OpenApi\Responses;

use Vyuldashev\LaravelOpenApi\Contracts\Reusable;

class ErrorAuthenticationResponse extends ErrorResponseFactory implements Reusable
{
    protected ?string $id = 'ErrorAuthentication';

    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;

    protected string $description = 'Authentication error';

    protected string $errorMessage = 'Unauthorized';
}
