<?php

namespace App\Http\Controllers\Api\V1\Request;

use App\Http\Controllers\Controller;
use App\Models\EngagementType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EngagementTypeController extends Controller
{
    public function component(): JsonResponse
    {
        $engagement_types = EngagementType::orderBy('id', 'asc')->get();
        return response()->json($engagement_types);
    }
}
