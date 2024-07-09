<?php

namespace App\Http\Controllers\Api\V1\Packages;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * The component functions
     */
    public function component(Request $request): JsonResponse
    {
        $packages = Package::all();
        return response()->json($packages);
    }
}
