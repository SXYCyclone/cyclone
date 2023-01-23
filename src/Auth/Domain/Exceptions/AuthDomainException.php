<?php

namespace Src\Auth\Domain\Exceptions;

use Src\Common\Domain\Exceptions\DomainException;

abstract class AuthDomainException extends DomainException
{
    public function getDomain(): string
    {
        return 'auth';
    }
}
