<?php

namespace App\Http\Controllers\Api\V1\MentorTutors;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* incoming request */
        $keyword = $request->only(['keyword', 'paginate', 'page']);

        /* call API to get all of the mentors and tutors */
        $request = Http::get( env('CRM_DOMAIN') . 'user/mentor-tutors', $keyword);
        $response = $request->json();

        return response()->json($response);
    }
}
