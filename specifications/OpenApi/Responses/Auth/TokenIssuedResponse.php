<?php

namespace Specifications\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Specifications\OpenApi\Responses\ResponseFactory;

class TokenIssuedResponse extends ResponseFactory
{
    protected string $description = 'User logged in successfully, and a token was issued.';

    public function definition(): array
    {
        return [
            Schema::string('access_token'),
            Schema::string('token_type')->example('bearer'),
            Schema::string('expires_in')->example(3600),
        ];
    }
}
