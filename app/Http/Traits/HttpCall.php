<?php

namespace App\Http\Traits;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HttpCall
{
    public function make_call(string $method, string $endpoint, array $params = []): array
    {
        try {

            $request = Http::withHeaders([
                'Header-ET' => $this->tokenService->get(),
            ])->{$method}( $endpoint, $params );
    
            if ( $request->failed() ) {
                Log::error('Failed to make a call to ' . $endpoint);
                throw new HttpResponseException(
                    response()->json([
                        'errors' => $request->json()
                    ], JsonResponse::HTTP_BAD_REQUEST)
                );
            }
        } catch (ConnectionException $err) {

            Log::error("The server isn't responding to host : {$endpoint} | {$err->getMessage()}");
            throw new HttpResponseException(
                response()->json(['errors' => "The server isn't responding." ])
            );
        }

        return [$request->getStatusCode(), $request->json()];
    }
}
