<?php

namespace Src\Agenda\Company\Domain\Exceptions;

use Illuminate\Http\Response;

class IncorrectVatFormatException extends CompanyDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('Vat must be valid');
    }
}
