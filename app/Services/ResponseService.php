<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ResponseService
{
    public function storeErrorLog(string $message, string $errors, array $value = [])
    {
        /* value array should contain file, error_line */

        $response = $message;
        $response .= '\n ' . $errors;
        if (isset($value)) {
            $response .= ' in file ' . $value['file'];
            $response .= ' on line ' . $value['error_line'];
        }

        Log::error($response, $value);
    }

    public function storeInfoLog(string $message, array $value = [])
    {
        $user = auth('sanctum')->user() ?? 'anonymous';
        Log::notice($user . ' : ' . $message, $value);
    }
}
