<?php

namespace Specifications\OpenApi\Responses\Auth;

use Specifications\OpenApi\Responses\ErrorResponseFactory;

class CredentialsInvalidResponse extends ErrorResponseFactory
{
    protected int $statusCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;

    protected string $description = 'Credentials invalid';

    protected string $errorMessage = 'The credentials are invalid';
}
