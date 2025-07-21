<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\CutoffAction;
use App\Exports\PayrollExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreCutoffRequest;
use App\Http\Requests\Payment\UnassignActivityRequest;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\Activity\ActivityDataService;
use App\Services\Timesheet\TimesheetDataService;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Exports\PayrollExportMultipleSheets;
use App\Http\Requests\Payment\CutoffExportRequest;
use App\Models\Cutoff;
use App\Services\Payment\PaymentService;

class CutoffController extends Controller
{
    public function store(
        StoreCutoffRequest $request,
        CutoffAction $cutoffAction,
    ): JsonResponse {
        $validated = $request->safe()->only(['start_date', 'end_date']);
        $validatedStartDate = $validated['start_date'];
        $validatedEndDate = $validated['end_date'];

        $activities = $cutoffAction->execute($validatedStartDate, $validatedEndDate);
        
        /* calculate the fees in order to help user know the total amount has been paid */
        $paidFee = $activities->sum('fee_hours');
        $additionalFee = $activities->sum('additional_fee');
        $bonusFee = $activities->sum('bonus_fee');
        $totalPaid = number_format($paidFee + $additionalFee + $bonusFee, 2, '.');

        $from = Carbon::parse($validatedStartDate)->format('F d');
        $to = Carbon::parse($validatedEndDate)->format('F d, Y');
        return response()->json([
            'message' => "Payments for all activities conducted from {$from} to {$to}, have been processed with Total Payment : IDR {$totalPaid}"
        ]);
    }

    public function unassign(
        UnassignActivityRequest $request,
        ResponseService $responseService,
        ): JsonResponse
    {  
        $validatedActivityIds = $request->activity_id;

        DB::beginTransaction();
        try {
            for ( $i = 0 ; $i < count($validatedActivityIds) ; $i++ )
            {
                $requestId = $validatedActivityIds[$i];
                $activity = Activity::find($requestId);
                # not yet meaning unpaid
                $activity->cutoff_status = "not yet";
                $activity->cutoff_ref_id = NULL;
                $activity->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $err_message = 'Failed to unassigned the activity.';
            $responseService->storeErrorLog( $err_message, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()] );
            throw new HttpResponseException(
                response()->json([
                    'errors' => $err_message
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return response()->json([
            'message' => 'The activity was successfully unassigned',
        ]);
    }

    public function export(
        CutoffExportRequest $request,
        PaymentService $paymentService,
        )
    {
        $validated = $request->safe()->only(['timesheet_id', 'cutoff_start', 'cutoff_end']);
        return $paymentService->exportPayrollAsASingleSheet($validated);
    }

    public function export_multiple(
        CutoffExportRequest $request,
        PaymentService $paymentService,
    )
    {
        $validated = $request->safe()->only(['cutoff_start', 'cutoff_end']);
        return $paymentService->exportPayrollAsMultipleSheets($validated);
    }

    public function export_summary(
        CutoffExportRequest $request,
        PaymentService $paymentService,
    )
    {
        $validated = $request->safe()->only(['cutoff_start', 'cutoff_end']);
        return $paymentService->exportPayrollSummary($validated);
    }
}
