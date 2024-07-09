<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function execute(ResponseService $responseService): JsonResponse
    {
        $userLoggedIn = auth('sanctum')->user();
        $userLoggedIn->logging_out();
        $userLoggedIn->currentAccessToken()->delete();

        $responseService->storeInfoLog('has logged out.');
        

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
