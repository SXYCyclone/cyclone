<?php

namespace Src\Common\Domain\Exceptions;

abstract class CommonDomainException extends DomainException
{
    public function getDomain(): string
    {
        return 'common';
    }
}
