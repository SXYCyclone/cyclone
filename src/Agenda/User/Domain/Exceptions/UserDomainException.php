<?php

namespace Src\Agenda\User\Domain\Exceptions;

use Src\Common\Domain\Exceptions\DomainException;

abstract class UserDomainException extends DomainException
{
    public function getDomain(): string
    {
        return 'user';
    }
}
