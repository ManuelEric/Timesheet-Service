<?php

namespace App\Services\Authentication;

use App\Models\TempUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;

class ResetPasswordService
{
    public function updateLocalPassword(string $token, string $email, string $password)
    {
        $status = Password::reset(
            [
                'token' => $token,
                'email' => $email,
                'password' => $password
            ],
            function (TempUser $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) 
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => __($status)
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }

    public function updateCrossPassword(string $email, string $password)
    {
        $request = Http::post( env('CRM_DOMAIN') . 'user/update', [
            'email' => $email,
            'password' => $password
        ]);
        $response = $request->getStatusCode();
        if ( $response !== 200 ) 
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to update password on cross domain.'
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }

    }
}
