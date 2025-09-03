<?php

namespace App\Actions\Authentication;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Models\CRM\User as CRMUser;
use App\Services\Token\TokenService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CheckEmailMentorTutorActionModel
{
    use ConcatenateName;
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    
    public function execute(string $email)
    {
        $user = CRMUser::where('email', $email)->first();
        if (!$user) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided email does not exists.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        /* initialize the data */
        $id = $user->id;
        $fullName = $this->concat($user->first_name, $user->last_name);
        $roles = $user->roles;
        $emailExist = $user->email ? true : false;
        $hasPassword = $user->password ? true : false;

        /* manipulate the response */
        $checkingResult = [
            'uuid' => $id,
            'full_name' => $fullName,
            'email_exist' => $emailExist,
            'has_password' => $hasPassword,
        ];

        $rawInformation = [
            'uuid' => $id,
            'full_name' => $fullName,
            'email' => $user->email,
            'phone' => $user->phone,
            'password' => $user->password,
            'roles' => collect($roles), // this will contains details of role such as data from tbl_user_subjects or user_streams
            'has_npwp' => $user->has_npwp,
            'account_name' => $user->account_name,
            'account_no' => $user->account_no,
            'bank_name' => $user->bank_name,
            'swift_code' => $user->swift_code,
            'active' => $user->active,
        ];

        $result = [$checkingResult, $rawInformation];

        return $result;
    }
}
