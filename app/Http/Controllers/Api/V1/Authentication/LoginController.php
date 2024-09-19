<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AuthenticateAdminRequest;
use App\Http\Requests\Authentication\AuthenticateNonAdminRequest;
use App\Services\Authentication\GenerateTokenService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    protected $generateTokenService;

    public function __construct(GenerateTokenService $generateTokenService)
    {
        $this->generateTokenService = $generateTokenService;
    }

    public function authenticateNonAdmin(
        AuthenticateNonAdminRequest $request,
        ): JsonResponse
    {
        $validated = $request->safe()->only(['email', 'password']);
        
        $authenticate = $this->generateTokenService->createNonAdminToken($validated);

        return response()->json($authenticate, JsonResponse::HTTP_OK);
    }

    public function authenticateAdmin(
        AuthenticateAdminRequest $request,
        ): JsonResponse
    {
        $validated = $request->safe()->only(['email', 'password']);
        
        $authenticate = $this->generateTokenService->createAdminToken($validated);

        return response()->json($authenticate, JsonResponse::HTTP_OK);
    }
}
