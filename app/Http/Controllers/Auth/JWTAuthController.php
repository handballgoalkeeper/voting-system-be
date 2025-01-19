<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Auth\AuthenticationFailedException;
use App\Exceptions\Auth\TokenParsingFailedException;
use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Facade\Auth\JWTAuthFacade;
use App\Facade\ResponseFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\JWT\LoginRequest;
use App\Services\Auth\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class JWTAuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        try {
            $user = $this->userService->findOneByEmail(email: $requestData['email']);
            $this->userService->validatePassword($user, $requestData['password']);
            $tokens = JWTAuthFacade::createAccessAndRefreshTokens($user->getId());
        }
        catch (
            EntityNotFoundException |
            DBOperationException |
            TokenParsingFailedException |
            AuthenticationFailedException $exception
        ) {
            return ResponseFacade::errorResponse(exception: $exception);
        }
        catch (Exception $exception) {
            return ResponseFacade::unhandledExceptionResponse(exception: $exception);
        }

        return response()->json($tokens);
    }
}
