<?php

namespace Src\Agenda\User\Domain\Exceptions;

use Illuminate\Http\Response;

final class PasswordsDoNotMatchException extends UserDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('Passwords do not match');
    }
}
