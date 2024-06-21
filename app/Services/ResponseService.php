<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ResponseService 
{
    public function storeErrorLog(string $message, string $errors, array $value = [])
    {
        $response = $message;
        $response .= '\n ' . $errors;
        if ( $value ) {
            $response .= ' in file ' . $value['file'];
            $response .= ' on line ' . $value['error_line'];
        }

        Log::error($response, $value);
    }
}
