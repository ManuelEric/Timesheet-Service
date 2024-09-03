<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Http\Traits\MonthCollection;
use App\Models\Ref_Program;
use App\Services\SummaryService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    use MonthCollection;
     /**
     * The component functions
     */
    public function list(Request $request): JsonResponse
    {
        $programs = Ref_Program::groupBy('program_name')->select('program_name')->get();
        return response()->json($programs);
    }

    public function summaryMonthlyPrograms(
        string $month,
        SummaryService $summaryService,
        ): JsonResponse
    {
        $program = $summaryService->summaryMonthlyPrograms($month);
        return response()->json($program, JsonResponse::HTTP_OK);
    }
}
