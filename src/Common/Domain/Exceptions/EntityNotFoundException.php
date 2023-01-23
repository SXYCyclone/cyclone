<?php

namespace Src\Common\Domain\Exceptions;

use Illuminate\Http\Response;

class EntityNotFoundException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_NOT_FOUND;

    public function __construct(string $message = 'Entity not found')
    {
        parent::__construct($message);
    }
}
