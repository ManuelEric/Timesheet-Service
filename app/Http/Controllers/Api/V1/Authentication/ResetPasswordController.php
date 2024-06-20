<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\TempUser;
use App\Services\Authentication\ResetPasswordService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function handle($token): JsonResponse
    {
        //! need to be remembered
        //! in the front-end, always provide the token box and bring the token back 

        /* TEMPORARY CODE */
        /* should be changed to route from front-end */
        return response()->json([
            'token' => $token
        ]);
    }

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
            $responseService->storeErrorLog('Failed to set new password.', $e->getMessage(), $validated);
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to set new password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }


        return response()->json([
            'message' => 'Password has been reset successfully.'
        ]);
    }
}
