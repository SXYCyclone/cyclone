<?php

namespace Src\Common\Domain\Exceptions;

use Illuminate\Http\Response;

final class RequiredException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public function __construct($fieldName)
    {
        parent::__construct(trans('validation.required', ['attribute' => $fieldName]));
    }
}
