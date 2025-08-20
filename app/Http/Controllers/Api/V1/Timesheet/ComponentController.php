<?php

namespace App\Http\Controllers\Api\V1\Timesheet;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Services\SummaryService;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function list(
        Request $request,
        TimesheetDataService $timesheetDataService,
        ): JsonResponse
    {
        $search = $request->only(['cutoff_start', 'cutoff_end', 'terms']);
        $timesheets = Timesheet::has('ref_program')->filterCutoff($search)->when(isset($search['terms']), function ($query) use ($search) {
            $query->whereRelation('subject.temp_user', 'full_name', 'like', '%'.$search['terms'].'%')->orderBy('created_at', 'desc');
        })->get();
        $mappedComponents = $timesheets->map(function ($data) use ($timesheetDataService)
        {
            /* initialize variables */
            $detailTimesheet = $timesheetDataService->detailTimesheet($data);
            unset($detailTimesheet['editableColumns']);

            /* manipulate variables */
            $clients = count($detailTimesheet['clientProfile']) > 1 ? implode(', ', array_column($detailTimesheet['clientProfile'], 'client_name')) : $detailTimesheet['clientProfile'][0]['client_name'];
            $programName = $detailTimesheet['packageDetails']['program_name'];
            $packageType = $detailTimesheet['packageDetails']['package_type'];
            $packageName = $detailTimesheet['packageDetails']['package_name'];
            $tutormentorName = $detailTimesheet['packageDetails']['tutormentor_name'];

            return [
                'id' => $data->id,
                'clients' => $clients,
                'tutormentor_name' => $tutormentorName,
                'program_name' => $programName,
                'package_type' => $packageType,
                'package_name' => $packageName,
                'timesheet_created_at' => $data->created_at,
            ];
        }); 

    
        return response()->json($mappedComponents);
    }

    public function summaryMonthlyTimesheet(
        string $month,
        SummaryService $summaryService,
        ): JsonResponse
    {
        $timesheet = $summaryService->summaryMonthlyTimesheets($month);
        return response()->json($timesheet, JsonResponse::HTTP_OK);
    }
}
