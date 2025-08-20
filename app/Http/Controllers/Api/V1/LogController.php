<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function index(string $visited_page, ?string $detail)
    {
        $user = auth('sanctum')->check() ? auth('sanctum')->user()->full_name : "Anonymous";
        $message = "{$user} has visited page {$visited_page}";
        if ($detail)
            $message .= " use detail {$detail}";

        Log::notice($message);

        return response()->json([
            'message' => 'Log has been created.'
        ], JsonResponse::HTTP_OK);
    }
}
