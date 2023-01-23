<?php

namespace Src\Agenda\User\Domain\Exceptions;

use Illuminate\Http\Response;

final class PasswordTooShortException extends UserDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('The password needs to be at least 8 characters long');
    }
}
