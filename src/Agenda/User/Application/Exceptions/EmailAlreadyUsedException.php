<?php

namespace Src\Agenda\User\Application\Exceptions;

use Illuminate\Http\Response;
use Src\Agenda\User\Domain\Exceptions\UserDomainException;

final class EmailAlreadyUsedException extends UserDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('The email is already in use');
    }
}
