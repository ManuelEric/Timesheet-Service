<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Models\Ref_ClientProgram;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* trigger to sync the success-program */
        Artisan::call('sync:success-program');


        /* incoming request */
        $keyword = $request->only(['program_name', 'timesheet_package']);

        $ref_success_programs = Ref_ClientProgram::onSearch($keyword)->paginate();
        
        return response()->json($ref_success_programs);
    }
}
