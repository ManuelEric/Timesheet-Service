<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\HiddenCostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\HiddenCostRequest;
use App\Models\TempUserRoles;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class FeeController extends Controller
{
    public function component(string $tutor_uuid, string $subject_name, string $curriculum_id)
    {
        $details = TempUserRoles::query()->
            select(['fee_individual', 'fee_group'])->
            where('temp_user_id', $tutor_uuid)->
            where('tutor_subject', $subject_name)->
            where('curriculum_id', $curriculum_id)->
            where('year', Carbon::now()->format('Y'))->
            where('head', 1)->
            first();
        return response()->json($details);
    }

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
