<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\ResetPasswordRequest;
use App\Services\Authentication\ResetPasswordService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function execute(
        ResetPasswordRequest $request,
        ResetPasswordService $resetPasswordService,
        ResponseService $responseService,
        ): JsonResponse
    {
        $validated = $request->safe()->only(['token', 'email', 'password']);
        $validatedToken = $validated['token'];
        $validatedEmail = $validated['email'];
        $validatedPassword = $validated['password'];

        
        DB::beginTransaction();
        try {
            $resetPasswordService->updateLocalPassword($validatedToken, $validatedEmail, $validatedPassword);

            $resetPasswordService->updateCrossPassword($validatedEmail, $validatedPassword);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $responseService->storeErrorLog('Failed to reset password.', $e->getMessage(), $validated);
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to reset password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }


        return response()->json([
            'message' => 'Password has been reset successfully.'
        ]);
    }
}
