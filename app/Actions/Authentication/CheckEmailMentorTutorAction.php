<?php

namespace App\Actions\Authentication;

use Illuminate\Support\Facades\Http;

class CheckEmailMentorTutorAction
{
    public function execute(string $email)
    {
        $fillableArray = [
            'uuid' => null, 'full_name' => null, 'email_exist' => null, 'has_password' => null
        ];

        $request = Http::get( env('CRM_DOMAIN') . 'oauth/email/check', [
            'email' => $email
        ]);
        $response = $request->json();

        if (empty($response)) 
            return $fillableArray;
        

        /* initialize the data */
        $uuid = $response['uuid'];
        $fullName = $response['first_name'] . ' ' . $response['last_name'];
        $emailExist = $response['email'] ? true : false;
        $hasPassword = $response['password'] ? true : false;
        
        /* manipulate the response */
        $fillableArray = [
            'uuid' => $uuid,
            'full_name' => $fullName,
            'email_exist' => $emailExist,
            'has_password' => $hasPassword,
        ];

        $result = $fillableArray;

        return $result;
    }
}
