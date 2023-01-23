<?php

namespace Src\Agenda\Company\Domain\Exceptions;

use Src\Common\Domain\Exceptions\DomainException;

abstract class CompanyDomainException extends DomainException
{
    public function getDomain(): string
    {
        return 'company';
    }
}
