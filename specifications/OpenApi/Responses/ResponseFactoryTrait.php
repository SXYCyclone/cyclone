<?php

namespace Specifications\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

trait ResponseFactoryTrait
{
    public function multipleOf(SchemaContract $schema, array $example = [], string $key = 'items'): SchemaContract
    {
        return Schema::array($key)->items($schema)->example(empty($example) ? null : $example);
    }

    public function error(string $domain, string $reason, string $message): SchemaContract
    {
        return Schema::object()
            ->properties(
                Schema::string('domain')->example($domain),
                Schema::string('reason')->example($reason),
                Schema::string('message')->example($message),
            );
    }
}
