<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Actions\Payment\HiddenCostAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\HiddenCostRequest;
use App\Http\Traits\StudentClub;
use App\Models\TempUserRoles;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class FeeController extends Controller
{
    use StudentClub;
    public function component_tutor(string $tutor_id, ?string $subject_name = null, ?string $curriculum_id = null, ?string $grade = null)
    {
        /**
         * because subject name and curriculum id is allow to be null
         * 
         * why subject name and curriculum allow to be null?
         * because mentor doesn't have neither subject nor curriculum
         * and this function can be called to check not only tutor, but mentor also
         */
        $subject_name = gettype($subject_name) == "string" && $subject_name == "null" ? null : $subject_name;
        $curriculum_id = gettype($curriculum_id) == "string" && $curriculum_id == "null" ? null : $curriculum_id;
        $grade = gettype($grade) == "string" && $grade == "null" ? null : $grade;

        /**
         * check if the subject name contains SAT
         * because for SAT, we should not check the grade
         */
        if (preg_match('/SAT/i', $subject_name)) {
            $grade = null;
        }

        $details = TempUserRoles::query()->
            select(['start_date', 'end_date', 'grade', 'fee_individual', 'fee_group'])->
            where('temp_user_id', $tutor_id)->
            when($subject_name, function ($query) use ($subject_name) {
                $query->where('tutor_subject', $subject_name);
            })->
            when($curriculum_id, function ($query) use ($curriculum_id) {
                $query->where('curriculum_id', $curriculum_id);
            })->
            when($grade, function ($query) use ($grade) {
                $query->whereRaw('? BETWEEN CAST(SUBSTRING_INDEX(REPLACE(REPLACE(grade, "[", ""), "]", ""), "-", 1) AS UNSIGNED) AND CAST(SUBSTRING_INDEX(REPLACE(REPLACE(grade, "[", ""), "]", ""), "-", -1) AS UNSIGNED)', [$grade]);
            })->
            whereRaw('now() BETWEEN start_date AND end_date')->
            active()->
            first();
        
        if ( !$details ) {
            throw new HttpResponseException(response()->json([
                'error' => 'Not found.'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }
        
        return response()->json($details);
    }

    public function component_extmentor(string $mentor_id, string $stream, string $engagement_type_id, string $package_id)
    {
        /** 
         * package_id 30 is student club hourly 
         * and because the fee of student club is same as professional sharing
         * then select fee from professional sharing (1-on-1 / 2-10 / > 10)  
         * 
        */

        [$engagement_type_id, $package_id] = $this->convertToProfessionalSharingPackageId((int)$engagement_type_id, (int)$package_id);

        $details = TempUserRoles::query()->
            select(['id', 'start_date', 'end_date', 'grade', 'fee_individual', 'fee_group'])->
            where('temp_user_id', $mentor_id)->
            when( $stream, function ($query) use ($stream) {
                $query->where('ext_mentor_stream', $stream);
            })->
            when($engagement_type_id, function ($query) use ($engagement_type_id) {
                $query->where('engagement_type_id', $engagement_type_id);
            })->
            when($package_id, function ($query) use ($package_id) {
                $query->where('package_id', $package_id);
            })->
            whereRaw('now() BETWEEN start_date AND end_date')->
            active()->
            first();

        if ( !$details ) {
            throw new HttpResponseException(response()->json([
                'error' => 'Not found.'
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        }

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
