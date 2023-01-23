<?php

namespace Src\Auth\Application;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Src\Agenda\User\Application\Mappers\UserMapper;
use Src\Agenda\User\Domain\Model\User;
use Src\Agenda\User\Infrastructure\EloquentModels\UserEloquentModel;
use Src\Auth\Domain\AuthInterface;
use Src\Auth\Domain\Exceptions\CredentialsInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as TymonJWTAuth;

class JWTAuth implements AuthInterface
{
    public function __construct(
        // private AvatarRepositoryInterface $avatarRepository
    ) {
    }

    public function login(array $credentials): string
    {
        $user = UserEloquentModel::query()->where('email', $credentials['email'])->first();
        if (!$user || !$user->is_active) {
            throw new CredentialsInvalidException('User not found or inactive');
        }

        if (!$token = auth()->attempt($credentials)) {
            throw new CredentialsInvalidException();
        }
        return $token;
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function me(): User
    {
        return UserMapper::fromAuth(auth()->user());
    }

    public function refresh(): string
    {
        try {
            return TymonJWTAuth::parseToken()->refresh();
        } catch (JWTException $e) {
            Log::error($e->getMessage());
            throw new AuthenticationException($e->getMessage());
        }
    }
}
