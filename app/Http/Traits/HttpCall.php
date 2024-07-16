<?php

namespace App\Http\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

trait HttpCall
{
    public function make_call(string $method, string $endpoint, array $params = []): array
    {
        $request = Http::withHeaders([
            'Header-ET' => $this->tokenService->get(),
        ])->{$method}( $endpoint, $params );

        if ( $request->failed() ) {
            throw new HttpResponseException(
                response()->json($request->json(), JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return [$request->getStatusCode(), $request->json()];
    }
}
