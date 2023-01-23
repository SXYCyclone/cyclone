<?php

namespace Specifications\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Specifications\OpenApi\Responses\ResponseFactory;

class TokenInvalidatedResponse extends ResponseFactory
{
    protected string $description = 'Logout';

    public function definition(): array
    {
        return [
            Schema::string('message')->example('Successfully logged out'),
        ];
    }
}
