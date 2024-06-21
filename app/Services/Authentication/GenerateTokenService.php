<?php

namespace App\Services\Authentication;

use App\Http\Traits\ConcatenateName;
use App\Models\TempUser;
use App\Models\User;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class GenerateTokenService 
{
    use ConcatenateName;
    
    public function createNonAdminToken(array $validated): array
    {
        /* call API to identify the user information */
        $request = Http::post( env('CRM_DOMAIN') . 'auth/token', $validated);
        $response = $request->json();

        if (!$response)
            return response()->json($response, JsonResponse::HTTP_BAD_REQUEST);  


        /* check if the user has already stored in timesheet app */
        $validatedEmail = $validated['email'];
        $validatedPassword = $validated['password'];
        $tempUser = TempUser::where('email', $validatedEmail)->first();
        if (! $tempUser)
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The account does not exist.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        
        /* check user credentials */
        if (!Hash::check($validatedPassword, $tempUser->password)) { # need to be remember that "tempUser->password" need to be updated also if the one in crm was updated, for now no update function (need to be discussed)
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided credentials are incorrect.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        /* generate token */
        $tempUser->authenticate();
        $granted_access = ['timesheet-menu'];
        $token = $tempUser->createToken('user-access', $granted_access)->plainTextToken;

        return [
            'full_name' => $tempUser->full_name,
            'email' => $tempUser->email,
            'granted_token' => $token
        ];

    }

    public function createAdminToken(array $validated): array
    {
        $validatedEmail = $validated['email'];
        $validatedPassword = $validated['password'];

        $user = User::where('email', $validatedEmail)->first();

        if (!$user || !Hash::check($validatedPassword, $user->password)) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided credentials are incorrect.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        /* generate token */
        $user->authenticate();
        switch ($user->role) {
            case 'finance':
                $granted_access = ['program-menu', 'timesheet-menu', 'cutoff-menu']; # all access granted for finance
                break;
            
            default:
                $granted_access = ['*']; # all access granted for admin
                break;
        }
        $token = $user->createToken('admin-access', $granted_access, Carbon::now()->addHours(1))->plainTextToken;

        return [
            'full_name' => $user->full_name,
            'email' => $user->email,
            'granted_token' => $token
        ];
    }
}
