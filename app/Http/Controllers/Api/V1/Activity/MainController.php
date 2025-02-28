<?php

namespace App\Http\Controllers\Api\V1\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Activity\CreateActivityAction;
use App\Actions\Activity\IdentifierCheckingAction as IdentifyActivityAction;
use App\Actions\Authentication\CheckEmailMentorTutorAction;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Traits\TranslateActivityStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use App\Http\Requests\Activity\StoreRequest as StoreActivityRequest;
use App\Http\Requests\Activity\UpdateRequest as UpdateActivityRequest;
use App\Services\Activity\ActivityDataService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    use TranslateActivityStatus;

    protected $identifyTimesheetIdAction;
    protected $responseService;

    public function __construct(IdentifyTimesheetIdAction $identifyTimesheetIdAction, ResponseService $responseService)
    {
        $this->identifyTimesheetIdAction = $identifyTimesheetIdAction;
        $this->responseService = $responseService;
    }
        

    public function index(
        $timesheetId,
        ActivityDataService $activityDataService,
        ): JsonResponse
    {
        $timesheet = $this->identifyTimesheetIdAction->execute($timesheetId);

        $activities = $activityDataService->listActivitiesByTimesheet($timesheet);

        return response()->json($activities);
    }

    public function show(
        $timesheetId,
        $activityId,
        IdentifyActivityAction $identifyActivityAction,
    )
    {
        $activity = $identifyActivityAction->execute($activityId, $timesheetId);
        return response()->json($activity);
    }

    public function store(
        $timesheetId,
        StoreActivityRequest $request, 
        CreateActivityAction $createActivityAction,
        ): JsonResponse
    {
        $timesheet = $this->identifyTimesheetIdAction->execute($timesheetId);

        $validated = $request->safe()->only(['description', 'start_date', 'end_date', 'meeting_link', 'status']);

        /* because now, the admin can manually input fee so the function below will be hide */
        /* unhide the function if fees data fetch from CRM */
        //$this->updateFee($timesheet);

        $createActivityAction->execute($timesheet, $validated);

        return response()->json([
            'message' => 'Activity has created successfully.'
        ]);

    }

    private function updateFee(
        $timesheet,
        CheckEmailMentorTutorAction $checkEmailMentorTutorAction
        )
    {
        /* get the newest information about the latest tutor/mentor fee hours who signed to handle the timesheet */
        $handleBy = $timesheet->handle_by->last();
        $itsEmail = $handleBy->email;
        $checkEmailMentorTutorAction->execute($itsEmail);
    }

    public function update(
        $timesheetId,
        $activityId,
        UpdateActivityRequest $request,
        IdentifyActivityAction $identifyActivityAction,
    )
    {
        $activity = $identifyActivityAction->execute($activityId, $timesheetId);

        $validated = $request->safe()->only(['description', 'start_date', 'end_date', 'meeting_link', 'status']);

        /* calculate spending time */
        $start_date = Carbon::parse($validated['start_date']);
        $end_date = Carbon::parse($validated['end_date']);
        $time_spent = $start_date->diffInMinutes($end_date);

        DB::beginTransaction();
        try {

            /* Update the activity */
            $activity->description = $validated['description'];
            $activity->start_date = $start_date;
            $activity->end_date = $end_date;
            $activity->time_spent = $time_spent;
            $activity->meeting_link = $validated['meeting_link'];

            /* update time_spent to 0 when user "uncheck" the status or update to "not yet" */ 
            if ( array_key_exists('status', $validated) )
            {
                $activity->status = $validated['status'];
                $activity->time_spent = $validated['status'] == 0 ? 0 : $time_spent; 
            } 

            $activity->save();
            DB::commit();

        } catch (Exception $err) {

            DB::rollBack();
            $errors = 'Failed to update the activity.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => $validated #new detail for the activity
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );

        }

        return response()->json([
            'message' => 'The Activity has been updated successfully.'
        ]);
    }

    /* the patch method going to handle update status activity */
    public function patch(
        $timesheetId,
        $activityId,
        Request $request,
        IdentifyActivityAction $identifyActivityAction,
        )
    {
        
        $activity = $identifyActivityAction->execute($activityId, $timesheetId);
        if ( $activity->cutoff_history !== null )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'This activity is now closed and cannot be modified.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }


        $timesheet = $activity->timesheet;

        $validated = $request->only(['status']);
        $validatedStatus = $validated['status'];

        if ( $validatedStatus == 1 )
        {
            /* initiate variables */
            $duration = (float) $timesheet->duration; // total minutes of package
            $total_hours_spent = $timesheet->activities()->whereNot('id', $activityId)->sum('time_spent');
    
            $this_activity_start_date = Carbon::parse($activity->start_date);
            $this_activity_end_date = Carbon::parse($activity->end_date);
            $x_minutes = $this_activity_start_date->diffInMinutes($this_activity_end_date);
            $activity->time_spent = $x_minutes;
    
            /* the time spent would be */
            $total_time_spent = $total_hours_spent + $x_minutes;
    
            if ( $duration < $total_time_spent )
            {
                return response()->json([
                    'message' => 'The specified duration exceeds the maximum limit. Please adjust accordingly.'
                ], 400);
            }
        }

        $activity->status = $validatedStatus;
        $activity->save();
        
        return response()->json([
            'message' => 'The activity has been marked complete.' 
        ]);


    }

    public function destroy(
        $timesheetId,
        $activityId,
        IdentifyActivityAction $identifyActivityAction,
    ): JsonResponse
    {
        $activity = $identifyActivityAction->execute($activityId, $timesheetId);

        DB::beginTransaction();
        try {
            $activity->delete();
            DB::commit();
        } catch (Exception $err) {
            DB::rollBack();
            $errors = 'Failed to delete the activity.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => [
                    'timesheet Id' => $timesheetId,
                    'activity Id' => $activityId
                ]
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return response()->json([
            'message' => 'The Activity has been deleted successfully.'
        ]);
    }
}
