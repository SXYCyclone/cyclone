<?php

namespace Src\Agenda\User\Presentation\HTTP;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Agenda\User\Application\Mappers\UserMapper;
use Src\Agenda\User\Application\UseCases\Commands\DestroyUserCommand;
use Src\Agenda\User\Application\UseCases\Commands\StoreUserCommand;
use Src\Agenda\User\Application\UseCases\Commands\UpdateUserCommand;
use Src\Agenda\User\Application\UseCases\Queries\FindAllUsersQuery;
use Src\Agenda\User\Application\UseCases\Queries\FindUserByIdQuery;
use Src\Agenda\User\Domain\Model\ValueObjects\Password;
use Src\Common\Infrastructure\Laravel\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->success((new FindAllUsersQuery())->handle());
    }

    public function show(int $id): JsonResponse
    {
        return response()->success((new FindUserByIdQuery($id))->handle());
    }

    public function store(Request $request): JsonResponse
    {
        $userData = UserMapper::fromRequest($request);
        $userData->validateNonAdminWithCompany();
        $password = new Password($request->input('password'), $request->input('password_confirmation'));
        $user = (new StoreUserCommand($userData, $password))->execute();
        return response()->success($user->toArray(), 'User created successfully', Response::HTTP_CREATED);
    }

    public function update(int $user_id, Request $request): JsonResponse
    {
        $user = UserMapper::fromRequest($request, $user_id);
        $password = new Password($request->input('password'), $request->input('password_confirmation'));
        (new UpdateUserCommand($user, $password))->execute();
        return response()->success($user->toArray());
    }

    public function destroy(int $user_id): JsonResponse
    {
        (new DestroyUserCommand($user_id))->execute();
        return response()->success(null, 'User deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
