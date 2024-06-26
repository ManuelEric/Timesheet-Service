<?php

namespace App\Actions\Authentication;

use App\Http\Traits\ConcatenateName;
use App\Services\ResponseService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CheckEmailMentorTutorAction
{
    use ConcatenateName; 
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(string $email)
    {
        $request = Http::get( env('CRM_DOMAIN') . 'auth/email/check', [
            'email' => $email
        ]);
        $response = $request->json();
        
        if (empty($response)) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided email does not exists.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
            

        /* initialize the data */
        $uuid = $response['uuid'];
        $fullName = $this->concat($response['first_name'], $response['last_name']);
        $roles = $response['roles'];
        $emailExist = $response['email'] ? true : false;
        $hasPassword = $response['password'] ? true : false;
        
        /* manipulate the response */
        $checkingResult = [
            'uuid' => $uuid,
            'full_name' => $fullName,
            'email_exist' => $emailExist,
            'has_password' => $hasPassword,
        ];

        $rawInformation = [
            'full_name' => $fullName,
            'email' => $response['email'],
            'password' => $response['password'],
            'roles' => $roles,
        ];

        $result = compact('checkingResult', 'rawInformation');

        return $result;
    }
}
