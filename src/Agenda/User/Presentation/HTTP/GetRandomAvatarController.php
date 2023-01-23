<?php

namespace Src\Agenda\User\Presentation\HTTP;

use Illuminate\Http\JsonResponse;
use Src\Agenda\User\Application\UseCases\Queries\GetRandomAvatarQuery;

class GetRandomAvatarController
{
    public function __invoke(): JsonResponse
    {
        return response()->success((new GetRandomAvatarQuery())->handle());
    }
}
