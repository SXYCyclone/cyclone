<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorAuthenticationResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::object()->properties(
            Schema::string('error')->example('Unauthorized'),
        );

        return Response::create('ErrorAuthentication')
            ->description('Authentication error')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
