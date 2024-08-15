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

    public function __construct($activityDataService, $timesheetDataService, $identifyTimesheetIdAction)
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
            $detailTimesheet = $this->timesheetDataService->detailTimesheet($timesheet);
            $activities = $this->activityDataService->listActivitiesByTimesheet($timesheet);
            unset($detailTimesheet['editableColumns']);

            $cutoff = Cutoff::inBetween($validatedCutoffStart, $validatedCutoffEnd)->first();
            $cutoffId = $cutoff->id;
            $activities = $activities->where('cutoff_ref_id', $cutoffId);
            
            return Excel::download(new PayrollExport($detailTimesheet, $activities), $this->filename);

        }

        throw new HttpResponseException(
            response()->json([
                'message' => 'No timesheet were found.'
            ], JsonResponse::HTTP_OK)
        );
    }

    public function exportPayrollAsMultipleSheets(array $validated)
    {
        $validatedCutoffStart = $validated['cutoff_start'];
        $validatedCutoffEnd = $validated['cutoff_end'];

        $timesheets = $this->timesheetDataService->listTimesheetByCutoffDate($validatedCutoffStart, $validatedCutoffEnd);

        foreach ( $timesheets as $timesheet )
        {
            $timesheet = $this->identifyTimesheetIdAction->execute($timesheet->id);
            $detailTimesheet = $this->timesheetDataService->detailTimesheet($timesheet);
            $activities = $this->activityDataService->listActivitiesByTimesheet($timesheet);

            // regist into the exports
            $exports[] = new PayrollExport($detailTimesheet, $activities);
        }

        return Excel::download(new PayrollExportMultipleSheets($exports), $this->filename);
    }
}
