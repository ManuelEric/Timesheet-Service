<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * The component functions
     */
    public function component(Request $request): JsonResponse
    {
        $users = User::select('id', 'full_name')->get();
        return response()->json($users);
    }
}
