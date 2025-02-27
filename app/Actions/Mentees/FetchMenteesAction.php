<?php

namespace App\Actions\Mentees;

use App\Http\Traits\HttpCall;
use App\Services\Token\TokenService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FetchMenteesAction
{
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    
    public function execute()
    {
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/admissions/list');

        if ( !$response ) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Unable to connect to the CRM'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
        
        return $response;
    }
}
