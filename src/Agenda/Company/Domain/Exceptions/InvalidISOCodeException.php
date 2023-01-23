<?php

namespace Src\Agenda\Company\Domain\Exceptions;

use Illuminate\Http\Response;
use Src\Common\Domain\Exceptions\CommonDomainException;

final class InvalidISOCodeException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct(__('country must be a valid ISO code (2 digits)'));
    }
}
