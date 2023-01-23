<?php

namespace Src\Common\Domain\Exceptions;

use Illuminate\Http\Response;

final class IncorrectEmailFormatException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('Must be a valid email');
    }
}
