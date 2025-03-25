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
    
    public function execute(string $mentor_uuid)
    {
        # k in get param means mentor_uuid
        # use k to hide from anyone on browser
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'program/admissions/list', ['k' => $mentor_uuid]);

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
