<?php

namespace Src\Common\Domain\Exceptions;

use Illuminate\Http\Response;

final class MaximumValueException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct($fieldName, $value)
    {
        parent::__construct(__("The maximum value for '$fieldName' is '$value"));
    }
}
