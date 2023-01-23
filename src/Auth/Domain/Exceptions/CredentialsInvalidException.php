<?php

namespace Src\Auth\Domain\Exceptions;

class CredentialsInvalidException extends AuthDomainException
{
    public int $httpCode = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;

    public function __construct(string $message = 'The credentials are invalid')
    {
        parent::__construct($message);
    }
}
