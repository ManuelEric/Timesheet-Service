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
        $search = $request->only(['program_name', 'keyword', 'paginate']);
        $additionalSearch = $request->only(['paginate', 'is_cancelled']);

        /* manage the variables of additional search */
        $isPaginate = $additionalSearch['paginate'] ?? false;
        $isCancelled = $additionalSearch['is_cancelled'] ?? false;
        $ref_success_programs = Ref_Program::tutoring()->onSearch($search)->onCancel($isCancelled)->orderBy('clientprog_id', 'desc')->get();

        $results = $isPaginate == true ? $ref_success_programs->paginate(10) : $ref_success_programs;
        return response()->json($results);
    }

}
