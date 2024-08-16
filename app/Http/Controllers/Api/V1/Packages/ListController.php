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
        /* incoming request */
        $search = $request->only(['category']);

        $packages = Package::onSearch($search)->get();
        return response()->json($packages);
    }
}
