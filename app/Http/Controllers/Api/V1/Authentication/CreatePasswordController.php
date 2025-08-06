<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\CreatePasswordRequest;
use App\Services\Authentication\ResetPasswordService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreatePasswordController extends Controller
{
    public function execute(
        CreatePasswordRequest $request,
        ResetPasswordService $resetPasswordService,
        ResponseService $responseService,
    ): JsonResponse {
        $validated = $request->safe()->only(['email', 'password']);
        $validatedEmail = $validated['email'];
        $validatedPassword = $validated['password'];

        DB::beginTransaction();
        try {
            $resetPasswordService->createLocalPassword($validatedEmail, $validatedPassword);

            $resetPasswordService->updateCrossPassword($validatedEmail, $validatedPassword);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $responseService->storeErrorLog('Failed to create password.', $e->getMessage(), $validated);
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to create password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return response()->json([
            'message' => 'Password has been created successfully.'
        ]);
    }
}
