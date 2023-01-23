<?php

namespace Src\Common\Domain\Exceptions;

final class IncorrectEmailFormatException extends CommonDomainException
{
    public function __construct()
    {
        parent::__construct('Must be a valid email');
    }
}
