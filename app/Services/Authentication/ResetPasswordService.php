<?php

namespace App\Services\Authentication;

use App\Http\Traits\HttpCall;
use App\Models\TempUser;
use App\Services\Token\TokenService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;

class ResetPasswordService
{
    use HttpCall;

    protected $tokenService;
    
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function createLocalPassword(string $email, string $password)
    {
        $user = TempUser::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();
    }

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
        [$statusCode, $response] = $this->make_call('post', env('CRM_DOMAIN') . 'user/update', ['email' => $email, 'password' => $password]);
        
        if ( $statusCode !== 200 ) 
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to update password on cross domain.'
                ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }

    }
}
