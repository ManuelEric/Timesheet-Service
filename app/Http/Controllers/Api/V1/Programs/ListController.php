<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Models\Ref_Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* incoming request */
        $search = $request->only(['program_name', 'keyword']);
        $ref_success_programs = Ref_Program::onSearch($search)->paginate(10);
        return response()->json($ref_success_programs);
    }

}
