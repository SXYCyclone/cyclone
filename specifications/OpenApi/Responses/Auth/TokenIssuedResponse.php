<?php

namespace Specifications\OpenApi\Responses\Auth;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class TokenIssuedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successfully logged in, and token issued')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('access_token'),
                        Schema::string('token_type')->example('bearer'),
                        Schema::string('expires_in')->example(3600),
                    )
                )
            );
    }
}
