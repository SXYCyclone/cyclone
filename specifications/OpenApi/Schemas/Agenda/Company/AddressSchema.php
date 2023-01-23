<?php

namespace Specifications\OpenApi\Schemas\Agenda\Company;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class AddressSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('AddressEloquentModel')
            ->properties(
                Schema::string('id')->default(null),
                Schema::integer('company_id')->default(0),
                Schema::string('name')->default(null),
                Schema::string('type')->default(null),
                Schema::string('street')->default(null),
                Schema::string('zip_code')->default(null),
                Schema::string('city')->default(null),
                Schema::string('country')->default(null),
                Schema::string('phone')->default(null),
                Schema::string('email')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
