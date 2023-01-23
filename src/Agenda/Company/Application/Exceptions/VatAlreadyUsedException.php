<?php

namespace Src\Agenda\Company\Application\Exceptions;

use Illuminate\Http\Response;
use Src\Agenda\Company\Domain\Exceptions\CompanyDomainException;

final class VatAlreadyUsedException extends CompanyDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct()
    {
        parent::__construct('Vat is already used');
    }
}
