<?php

namespace App\Actions;

use App\Http\Traits\HttpCall;
use App\Services\Token\TokenService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FetchTempUserAction
{
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function execute($uuid)
    {
        [$statusCode, $response] = $this->make_call('get', env('CRM_DOMAIN') . 'user/mentor-tutors/' . $uuid);

        if ( !$response ) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Unable to connect to the CRM'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
        
        return $response['password'];
    }
}
