<?php

namespace Src\Auth\Presentation\HTTP;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Specifications\OpenApi\RequestBodies\Auth\LoginRequestBody;
use Specifications\OpenApi\Responses\Auth\CurrentUserResponse;
use Specifications\OpenApi\Responses\Auth\TokenInvalidatedResponse;
use Specifications\OpenApi\Responses\Auth\TokenIssuedResponse;
use Specifications\OpenApi\Responses\ErrorAuthenticationResponse;
use Specifications\OpenApi\Responses\ErrorValidationResponse;
use Src\Auth\Domain\AuthInterface;
use Src\Common\Infrastructure\Laravel\Controller;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AuthController extends Controller
{
    private AuthInterface $auth;

    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\RequestBody(factory: LoginRequestBody::class)]
    #[OpenApi\Response(factory: TokenIssuedResponse::class)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 400)]
    #[OpenApi\Response(factory: ErrorAuthenticationResponse::class, statusCode: 401)]
    public function login(Request $request): JsonResponse
    {
        try {
            $email = $request->get('email');
            $password = $request->get('password');
            $credentials = ['email' => strtolower($email), 'password' => $password];
            $validator = Validator::make($credentials, [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $token = $this->auth->login($credentials);
            return $this->respondWithToken($token);
        } catch (AuthenticationException) {
            return Response::fail('Failed to log in', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Get the authenticated UserEloquentModel.
     *
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\Response(factory: CurrentUserResponse::class)]
    #[OpenApi\Response(factory: ErrorAuthenticationResponse::class, statusCode: 401)]
    public function me(): JsonResponse
    {
        return Response::success($this->auth->me()->toArray());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\Response(factory: TokenInvalidatedResponse::class)]
    public function logout(): JsonResponse
    {
        $this->auth->logout();
        return Response::success(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\Response(factory: TokenIssuedResponse::class)]
    #[OpenApi\Response(factory: ErrorAuthenticationResponse::class, statusCode: 401)]
    public function refresh(): JsonResponse
    {
        try {
            $token = $this->auth->refresh();
        } catch (AuthenticationException $e) {
            return Response::fail('Unauthorized', Response::HTTP_FORBIDDEN);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return Response::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 1,
        ]);
    }
}
