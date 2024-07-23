<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\CutoffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreCutoffRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

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
}
