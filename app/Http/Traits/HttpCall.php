<?php

namespace App\Http\Traits;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HttpCall
{
    public function make_call(string $method, string $endpoint, array $params = [], array $additional_headers = []): array
    {
        $headers = [
            'Header-ET' => $this->tokenService->get(),
            'Accept' => 'application/json',
        ];

        if ( !empty($additional_headers) && count($additional_headers) > 0 ) {
            $headers = array_merge($headers, $additional_headers);
        }
        
        try {

            $request = Http::
            withoutVerifying()->
            withHeaders($headers)->
            withOptions(['verify' => false])->
            timeout(60)->{$method}( $endpoint, $params );
    
            if ( $request->failed() ) {
                Log::error('Failed to make a call to ' . $endpoint, $request->json());
                throw new HttpResponseException(
                    response()->json([
                        'errors' => $request->json()
                    ], JsonResponse::HTTP_BAD_REQUEST)
                );
            }
        } catch (ConnectionException $err) {

            Log::error("The server isn't responding to host : {$endpoint} | {$err->getMessage()}");
            throw new HttpResponseException(
                response()->json(['errors' => "The server isn't responding."], JsonResponse::HTTP_SERVICE_UNAVAILABLE)
            );
        }

        return [$request->getStatusCode(), $request->json()];
    }
}
