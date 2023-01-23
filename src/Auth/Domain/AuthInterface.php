<?php

namespace Src\Auth\Domain;

use Illuminate\Auth\AuthenticationException;
use Src\Agenda\User\Domain\Model\User;
use Src\Auth\Domain\Exceptions\CredentialsInvalidException;

interface AuthInterface
{
    /**
     * @throws CredentialsInvalidException if credentials are invalid
     * @throws AuthenticationException if internal error
     */
    public function login(array $credentials): string;

    /**
     * @throws AuthenticationException
     */
    public function refresh(): string;

    public function logout(): void;

    public function me(): User;
}
