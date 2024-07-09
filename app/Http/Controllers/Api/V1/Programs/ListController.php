<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Models\Ref_Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* trigger to sync the success-program */
        Artisan::call('sync:success-program');

        /* incoming request */
        $search = $request->only(['program_name', 'keyword']); 

        $ref_success_programs = Ref_Program::onSearch($search)->paginate(10);
        
        return response()->json($ref_success_programs);
    }

    /**
     * The component functions
     */
    public function component(Request $request): JsonResponse
    {
        $programs = Ref_Program::groupBy('program_name')->select('program_name')->get();
        return response()->json($programs);
    }
}
