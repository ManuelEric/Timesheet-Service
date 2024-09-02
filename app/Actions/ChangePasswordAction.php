<?php

namespace App\Actions;

use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(array $request)
    {
        $validatedCurrentPassword = $request['current_password'];
        $validatedNewPassword = $request['new_password'];

        $authUser = auth('sanctum')->user();
        $currentAuthPassword = $authUser->password;

        /* check if the passwords matches */
        if ( !Hash::check($validatedCurrentPassword, $currentAuthPassword) )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Current password is Invalid.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        /* check if the current password and the new password are same */
        if ( strcmp($validatedCurrentPassword, $validatedNewPassword) == 0 )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'New Password cannot be same as your current password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        DB::beginTransaction();
        try {

            $authUser->password = Hash::make($validatedNewPassword);
            $authUser->save();
            DB::commit();

        } catch (Exception $err) {
            
            DB::rollBack();
            $errors = 'Failed to update password.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => $request
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );

        }
    }
}
