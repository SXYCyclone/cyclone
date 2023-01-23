<?php

namespace Src\Auth\Domain\Exceptions;

class CredentialsInvalidException extends AuthDomainException
{
    public function __construct(string $message = 'The credentials are invalid')
    {
        parent::__construct($message);
    }
}
