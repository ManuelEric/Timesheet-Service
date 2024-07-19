<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\HiddenCostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\HiddenCostRequest;
use Illuminate\Http\JsonResponse;

class FeeController extends Controller
{
    public function store(
        HiddenCostRequest $request,
        HiddenCostAction $hiddenCostAction,
        ): JsonResponse
    {
        $validated = $request->safe()->only(['timesheet_id', 'date', 'fee']);
        $validatedTimesheetId = $validated['timesheet_id'];
        $validatedDate = $validated['date'];
        $validatedFee = $validated['fee'];

        $hiddenCostAction->execute('additional-fee', $validatedTimesheetId, $validatedDate, $validatedFee);

        return response()->json([
            'message' => 'The additional fee has been added into timesheets.'
        ]);
    }
}
