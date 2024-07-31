<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Activity\CreateActivityAction;
use App\Actions\Activity\IdentifierCheckingAction as IdentifyActivityAction;
use App\Actions\Authentication\CheckEmailMentorTutorAction;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\TranslateActivityStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use App\Http\Requests\Activity\StoreRequest as StoreActivityRequest;
use App\Http\Requests\Activity\UpdateRequest as UpdateActivityRequest;
use App\Models\Activity;
use App\Services\Activity\ActivityDataService;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
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

        $activities = $activityDataService->listActivities($timesheet);

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
        CheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        CreateActivityAction $createActivityAction,
        ): JsonResponse
    {
        $timesheet = $this->identifyTimesheetIdAction->execute($timesheetId);

        $validated = $request->safe()->only(['activity', 'description', 'start_date', 'end_date', 'meeting_link', 'status']);

        /* get the newest information about the latest tutor/mentor fee hours who signed to handle the timesheet */
        $handleBy = $timesheet->handle_by->last();
        $itsEmail = $handleBy->email;

        [$checkingResult, $userInformation] = $checkEmailMentorTutorAction->execute($itsEmail);
        
        $createActivityAction->execute($timesheet, $validated);

        return response()->json([
            'message' => 'Activity has created successfully.'
        ]);

    }

    public function update(
        $timesheetId,
        $activityId,
        UpdateActivityRequest $request,
        IdentifyActivityAction $identifyActivityAction,
    )
    {
        $activity = $identifyActivityAction->execute($activityId, $timesheetId);

        $validated = $request->safe()->only(['activity', 'description', 'start_date', 'end_date', 'meeting_link', 'status']);

        /* calculate spending time */
        $start_date = Carbon::parse($validated['start_date']);
        $end_date = Carbon::parse($validated['end_date']);
        $time_spent = $start_date->diffInMinutes($end_date);

        DB::beginTransaction();
        try {

            /* Update the activity */
            $activity->activity = $validated['activity'];
            $activity->description = $validated['description'];
            $activity->start_date = $start_date;
            $activity->end_date = $end_date;
            $activity->time_spent = $time_spent;
            $activity->meeting_link = $validated['meeting_link'];

            if ( array_key_exists('status', $validated) )
                $activity->status = $validated['status'];

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
