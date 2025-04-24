<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;



/**
 * @group Authentication
 * @groupDescription Handles user authentication operations including login, registration, and logout functionality
 */
class AuthController extends Controller
{


 public AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

        /**
     * User Registration
     *
     * Registers a new user in the system and returns an authentication token.
     * @return \Illuminate\Http\JsonResponse
     */


    public function register(RegisterRequest $request):JsonResponse
    {
        return $this->authService->register($request)->toJson();
    }

    public function login(LoginRequest $request): JsonResponse
    {

        return $this->authService->login($request)->toJson();

    }


    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout($request)->toJson();
    }

    public function adminLogin(LoginRequest $request): JsonResponse
    {
        return $this->authService->adminLogin($request)->toJson();
    }


    public function adminLogout(Request $request): JsonResponse
    {
        return $this->authService->logout($request)->toJson();
    }
}
