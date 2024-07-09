<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(
        Request $request,
        ResponseService $responseService,
        ): JsonResponse
    {
        $validated = $request->only('email');

        $status = Password::sendResetLink($validated);

        if ($status !== Password::RESET_LINK_SENT) 
        {
            $responseService->storeErrorLog('Failed to send reset link.', __($status));
            throw new HttpResponseException(
                response()->json([
                    'errors' => __($status)
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        $logDetails = [
            'info' => $validated['email']
        ];
        $responseService->storeInfoLog('Has requested reset password link.', $logDetails);

        return response()->json([
            'message' => 'A password reset link has been sent to your email address. Please check your inbox (including spam) and follow the instructions to reset your password.'
        ]);

    }
}
