<?php

namespace App\Actions\Authentication;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Services\Token\TokenService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CheckEmailMentorTutorAction
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
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'auth/email/check', ['email' => $email]);
        if ( ! $response ) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided email does not exists.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        /* initialize the data */
        $id = $response['id'];
        $fullName = $this->concat($response['first_name'], $response['last_name']);
        $roles = $response['roles'];
        $emailExist = $response['email'] ? true : false;
        $hasPassword = $response['password'] ? true : false;

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
            'email' => $response['email'],
            'phone' => $response['phone'],
            'password' => $response['password'],
            'roles' => collect($roles), // this will contains details of role such as data from tbl_user_subjects or user_streams
            'has_npwp' => $response['has_npwp'],
            'account_name' => $response['account_name'],
            'account_no' => $response['account_no'],
            'bank_name' => $response['bank_name'],
            'swift_code' => $response['swift_code'],
            'active' => $response['active'],
        ];

        $result = [$checkingResult, $rawInformation];

        return $result;
    }
}
