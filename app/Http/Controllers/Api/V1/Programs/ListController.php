<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListProgramCollection;
use App\Http\Resources\ListProgramResource;
use App\Models\Ref_Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* incoming request */
        $search = $request->only(['program_name', 'keyword', 'has_timesheet', 'require']);
        $additionalSearch = $request->only(['paginate', 'is_cancelled']);

        /* manage the variables of additional search */
        $isPaginate = $additionalSearch['paginate'] ?? false;
        $isCancelled = $additionalSearch['is_cancelled'] ?? false;
        $ref_success_programs = Ref_Program::with([
            'timesheet' => function ($query) {
                $query->select('id', 'subject_id');
            },
            'timesheet.subject' => function ($query) {
                $query->select('id', 'temp_user_id');
            },
            'timesheet.subject.temp_user' => function ($query) {
                $query->select('id', 'full_name');
            },
            'second_timesheet' => function ($query) {
                $query->select('id', 'subject_id');
            },
            'second_timesheet.subject' => function ($query) {
                $query->select('id', 'temp_user_id');
            },
            'second_timesheet.subject.temp_user' => function ($query) {
                $query->select('id', 'full_name');
            },
            'curriculums',
            'packages'

        ])->tutoring()->onSearch($search)->onCancel($isCancelled)->newest()->get();

        $results = $isPaginate == true ? $ref_success_programs->paginate(10) : $ref_success_programs;
        return response()->json($isPaginate == true ? new ListProgramCollection($results) : ListProgramResource::collection($results));
    }

}
