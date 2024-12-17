<?php

namespace App\Actions;

use App\Models\TempUser;
use App\Services\Authentication\ResetPasswordService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    protected $fetchTempUserAction;
    protected $responseService;
    protected $resetPasswordService;

    public function __construct(
        FetchTempUserAction $fetchTempUserAction,
        ResponseService $responseService,
        ResetPasswordService $resetPasswordService,
        )
    {
        $this->fetchTempUserAction = $fetchTempUserAction;
        $this->responseService = $responseService;
        $this->resetPasswordService = $resetPasswordService;
    }

    public function execute(array $request)
    {
        $validatedCurrentPassword = $request['current_password'];
        $validatedNewPassword = $request['new_password'];

        $authUser = auth('sanctum')->user();
        $authUserUuid = $authUser->uuid;
        $authUserEmail = $authUser->email;

        /* check if the passwords matches */
        $authUser_CRM_password = $this->fetchTempUserAction->execute($authUserUuid);
        if ( !Hash::check($validatedCurrentPassword, $authUser_CRM_password) )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Current password is Invalid.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        /* check if the current password and the new password are same */
        if ( strcmp($authUser_CRM_password, $validatedNewPassword) == 0 )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'New Password cannot be same as your current password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        DB::beginTransaction();
        try {

            /* update password on cross domain */
            $this->resetPasswordService->updateCrossPassword($authUserEmail, $validatedNewPassword);

            /* update password on local domain */
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
