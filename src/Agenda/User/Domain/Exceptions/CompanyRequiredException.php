<?php

namespace Src\Agenda\User\Domain\Exceptions;

use Illuminate\Http\Response;

class CompanyRequiredException extends UserDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('Company is required for non-admin users');
    }
}
