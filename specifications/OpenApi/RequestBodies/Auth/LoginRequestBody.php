<?php

namespace Specifications\OpenApi\RequestBodies\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Specifications\OpenApi\RequestBodies\RequestBodyFactory;

class LoginRequestBody extends RequestBodyFactory
{
    public function definition(): array
    {
        return [
            Schema::string('email'),
            Schema::string('password'),
        ];
    }
}
