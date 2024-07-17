<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\CutoffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreCutoffRequest;
use App\Rules\CutoffDate;
use Illuminate\Support\Carbon;

class CutoffController extends Controller
{
    public function store(
        StoreCutoffRequest $request,
        CutoffAction $cutoffAction,
    ) {
        $validated = $request->safe()->only(['start_date', 'end_date']);
        $validatedStartDate = $validated['start_date'];
        $validatedEndDate = $validated['end_date'];

        $cutoffAction->execute($validatedStartDate, $validatedEndDate);

        $from = Carbon::parse($validatedStartDate)->format('F d');
        $to = Carbon::parse($validatedEndDate)->format('F d, Y');
        return response()->json([
            'message' => "Payments for all activities conducted from {$from} to {$to}, have been processed."
        ]);
    }
}
