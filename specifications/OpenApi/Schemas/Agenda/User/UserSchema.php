<?php

namespace Specifications\OpenApi\Schemas\Agenda\User;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserEloquentModel')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('name')->default(null),
                Schema::string('company_id')->default(null),
                Schema::string('avatar')->default(null),
                Schema::string('email')->default(null),
                Schema::string('password')->default(null),
                Schema::string('email_verified_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::boolean('is_admin')->default(''),
                Schema::boolean('is_active')->default('1'),
                Schema::string('remember_token')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
