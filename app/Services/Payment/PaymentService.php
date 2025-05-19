<?php

namespace App\Services\Payment;

use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Activity\ActivityDataService;
use App\Services\Timesheet\TimesheetDataService;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Exports\PayrollExportMultipleSheets;
use App\Models\Cutoff;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class PaymentService
{
    protected $activityDataService;
    protected $timesheetDataService;
    protected $identifyTimesheetIdAction;
    protected $filename;

    public function __construct(
        ActivityDataService $activityDataService,
        TimesheetDataService $timesheetDataService, 
        IdentifyTimesheetIdAction $identifyTimesheetIdAction)
    {
        $this->activityDataService = $activityDataService;
        $this->timesheetDataService = $timesheetDataService;
        $this->identifyTimesheetIdAction = $identifyTimesheetIdAction;

        // $filename = $this->generateFileName($mappedTimesheetData);
        $this->filename = 'Payroll_' . date('F_Y') . '.xlsx';
    }

    public function exportPayrollAsASingleSheet(array $validated)
    {
        $validatedTimesheetId = $validated['timesheet_id'] ?? null;
        $validatedCutoffStart = $validated['cutoff_start'];
        $validatedCutoffEnd = $validated['cutoff_end'];
        
        if ( $validatedTimesheetId ) {
            $timesheet = $this->identifyTimesheetIdAction->execute($validatedTimesheetId);
            if ( !$timesheet )
            {
                throw new HttpResponseException(
                    response()->json([
                        'errors' => 'No downloadable activities were found.'
                    ], JsonResponse::HTTP_BAD_REQUEST)
                );
            }


            $detailTimesheet = $this->timesheetDataService->detailTimesheet($timesheet);
            $activities = $this->activityDataService->listActivitiesByTimesheet($timesheet);
            unset($detailTimesheet['editableColumns']);

            $cutoff = Cutoff::inBetween($validatedCutoffStart, $validatedCutoffEnd)->first();
            $cutoffId = $cutoff->id;
            $activities = $activities->where('cutoff_ref_id', $cutoffId);
            
            return Excel::download(new PayrollExport($detailTimesheet, $activities, $cutoff), $this->filename);

        }

        throw new HttpResponseException(
            response()->json([
                'message' => 'No timesheet were found.'
            ], JsonResponse::HTTP_BAD_REQUEST)
        );
    }

    public function exportPayrollAsMultipleSheets(array $validated)
    {
        $validatedCutoffStart = $validated['cutoff_start'];
        $validatedCutoffEnd = $validated['cutoff_end'];

        $timesheets = $this->timesheetDataService->listTimesheetByCutoffDate($validatedCutoffStart, $validatedCutoffEnd);
        if ( count($timesheets) == 0 )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'No downloadable activities were found.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        //! perlu di sorting by tutor name
        foreach ( $timesheets as $timesheet )
        {
            if (!isset($timesheet->reference_program))
                continue;

            $timesheet = $this->identifyTimesheetIdAction->execute($timesheet->id);
            $detailTimesheet = $this->timesheetDataService->detailTimesheet($timesheet);
            $activities = $this->activityDataService->listActivitiesByTimesheet($timesheet);

            $cutoff = Cutoff::inBetween($validatedCutoffStart, $validatedCutoffEnd)->first();
            $cutoffId = $cutoff->id;
            $activities = $activities->where('cutoff_ref_id', $cutoffId);
            
            // echo json_encode($activities);
            // echo '<br>';
            // echo 'cutoff ref id terakhir ' . $activities[count($activities)-1]['cutoff_ref_id']. ' dari total activities '. count($activities);
            // echo '<br><br><br><br><br><br>';continue;

            // regist into the exports
            $exports[] = new PayrollExport($detailTimesheet, $activities, $cutoff);
        }
        // exit;

        return Excel::download(new PayrollExportMultipleSheets($exports), $this->filename);
    }
}
