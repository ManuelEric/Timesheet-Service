<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateAdminRequest;
use App\Http\Requests\AuthenticateNonAdminRequest;
use App\Models\User;
use App\Services\Authentication\GenerateTokenService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
