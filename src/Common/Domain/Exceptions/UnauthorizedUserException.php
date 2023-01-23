<?php

namespace Src\Common\Domain\Exceptions;

use Illuminate\Http\Response;

final class UnauthorizedUserException extends CommonDomainException
{
    public int $httpCode = Response::HTTP_FORBIDDEN;

    public function __construct(string $custom_message = '')
    {
        parent::__construct($custom_message ?: 'The user is not authorized to access this resource or perform this action');
    }
}
