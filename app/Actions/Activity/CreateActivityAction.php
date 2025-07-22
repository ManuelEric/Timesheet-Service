<?php

namespace App\Actions\Activity;

use App\Http\Traits\PackageType;
use App\Models\Activity;
use App\Models\Timesheet;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateActivityAction
{
    use PackageType;
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(Timesheet $timesheet, array $validated)
    {
        $timesheetId = $timesheet->id;

        /* default variables */
        $package = $timesheet->package;
        $packageCategory = $package->category;
        [$type, $tutor_mentor] = $this->convert($packageCategory);

        /**
         * before determine the fee hours 
         * we need to check how many student that the tutor/mentor handle
         */
        $head = count($timesheet->ref_program);
        $isGroup = $head > 1 ? true : false;
        $fee_perHours = 0; # default

        /**
         * in order to protect from paying editor for activity that not suit with agreement in CRM
         * need to check either the subject is active or not
         * if the subject is not active, then prevent editor from creating activity 
         */
        //! but for now this function will be commented out
        // if ($timesheet->subject->is_active == 0) {
        //     $errors = 'The agreement associated with your account has been deprecated and is no longer valid, so new activities cannot be created under it.';
        //     throw new HttpResponseException(
        //         response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        //     );
        // }
        //! commented function end here

        $tax = $timesheet->subject->tax;

        if ( $type == "tutoring" )
        {
            $fee_perHours = $isGroup ? $timesheet->subject->fee_group : $timesheet->subject->fee_individual;
        }
        elseif ( $type == "mentoring" )
        {
            $fee_perHours = $timesheet->subject->fee_individual;
        }

        $endDate = array_key_exists('end_date', $validated) ? $validated['end_date'] : NULL;
        $additionalFee = $bonusFee = $status = 0;
        $program_name = $timesheet->reference_program[0]->program_name;

        /* when the request comes from fee controller */
        if ( array_key_exists('additional_fee', $validated) ) 
        {
            $fee_perHours = $tax = 0;
            $additionalFee = $validated['additional_fee'];
            $program_name = $validated['activity'];
            $status = 1;
        } 

        /* when the request comes from bonus controller */
        if ( array_key_exists('bonus_fee', $validated) ) 
        {
            $fee_perHours = $tax = 0;
            $bonusFee = $validated['bonus_fee'];
            $program_name = $validated['activity'];
            $status = 1;
        } 

        DB::beginTransaction();
        try {

            $activityDetails = [
                'timesheet_id' => $timesheetId,
                'activity' => $program_name,
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $endDate,
                'tax' => $tax,
                'fee_hours' => $fee_perHours,
                'additional_fee' => $additionalFee,
                'bonus_fee' => $bonusFee,
                'time_spent' => 0,
                'meeting_link' => $validated['meeting_link'],
                'status' => $status,
            ];
    
            Activity::create($activityDetails);
            DB::commit();
            
        } catch (Exception $err) {
            
            DB::rollBack();
            $errors = 'Failed to create new activity.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => []
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
            
        }
    }
}
