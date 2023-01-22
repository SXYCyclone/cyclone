<?php

namespace Specifications\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory as BaseRequestBodyFactory;

abstract class RequestBodyFactory extends BaseRequestBodyFactory
{
    public function build(): RequestBody
    {
        $request = RequestBody::create();
        $definition = $this->definition();
        $content = MediaType::json()->schema(
            Schema::object()->properties(
                ...$definition
            )
        );
        return $request->content($content);
    }

    /**
     * @return SchemaContract[]
     */
    abstract public function definition(): array;
}
