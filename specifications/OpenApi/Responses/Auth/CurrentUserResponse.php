<?php

namespace Specifications\OpenApi\Responses\Auth;

use Specifications\OpenApi\Responses\ResponseFactory;
use Specifications\OpenApi\Schemas\Agenda\User\UserSchema;

class CurrentUserResponse extends ResponseFactory
{
    protected string $description = 'Current user';

    public function definition(): array
    {
        return (new UserSchema())->build()->properties;
    }
}
