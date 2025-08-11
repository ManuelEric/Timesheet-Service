<?php

namespace App\Http\Traits;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

trait HttpCall
{
    public function make_call(string $method, string $endpoint, array $params = [], array $additional_headers = []): array
    {
        $allowedMethods = ['get', 'post', 'put', 'patch', 'delete'];
        if (!in_array(strtolower($method), $allowedMethods)) {
            throw new InvalidArgumentException("Invalid HTTP method: $method");
        }

        $headers = [
            'Header-ET' => $this->tokenService->get(),
            'Content-Type' => 'application/json',
        ];

        if ( !empty($additional_headers) && count($additional_headers) > 0 ) {
            $headers = array_merge($headers, $additional_headers);
        }
        
        try {

            $request = Http::
            withoutVerifying()->
            withHeaders($headers)->
            timeout(60)->{$method}( $endpoint, $params );

            if ( $request->failed() ) {
                Log::error('Failed to make a call to ' . $endpoint, [
                    'body' => $request->json() ?? $request->body()
                ]);
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
        } catch (Exception $ex) {
            Log::error("Unexpected HTTP error: {$ex->getMessage()}");
            throw new HttpResponseException(
                response()->json(['errors' => "Unexpected error."], JsonResponse::HTTP_INTERNAL_SERVER_ERROR)
            );
        }

        return [$request->getStatusCode(), $request->json()];
    }
}
