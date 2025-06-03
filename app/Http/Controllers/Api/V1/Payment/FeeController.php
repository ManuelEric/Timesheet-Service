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
    public function component(string $tutor_uuid, ?string $subject_name = null, ?string $curriculum_id = null)
    {
        /**
         * because subject name and curriculum id is allow to be null
         * 
         * why subject name and curriculum allow to be null?
         * because mentor doesn't have neither subject nor curriculum
         * and this function can be called to check not only tutor, but mentor also
         */
        $subject_name = gettype($subject_name) == "string" ? null : $subject_name;
        $curriculum_id = gettype($curriculum_id) == "string" ? null : $curriculum_id;

        $details = TempUserRoles::query()->
            select(['fee_individual', 'fee_group'])->
            where('temp_user_id', $tutor_uuid)->
            when($subject_name, function ($query) use ($subject_name) {
                $query->where('tutor_subject', $subject_name);
            })->
            when($curriculum_id, function ($query) use ($curriculum_id) {
                $query->where('curriculum_id', $curriculum_id);
            })->
            where('year', Carbon::now()->format('Y'))->
            where(function ($query) {
                $query->where('head', 1)->orWhereNull('head');
            })->            
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
