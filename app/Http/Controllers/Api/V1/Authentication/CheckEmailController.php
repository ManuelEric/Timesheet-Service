<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Actions\Authentication\CheckEmailAdminAction as AuthenticationCheckEmailAdminAction;
use App\Actions\Authentication\CheckEmailMentorTutorAction as AuthenticationCheckEmailMentorTutorAction;
use App\Actions\Logging\StoreLogAction as TimesheetLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckEmailRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CheckEmailController extends Controller
{
    public function execute(
        CheckEmailRequest $request,
        AuthenticationCheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        TimesheetLog $timesheetLog
        ): JsonResponse
    {
        $validated = $request->safe()->only(['email']);
        $validatedEmail = $validated['email'];
        
        $result = $checkEmailMentorTutorAction->execute($validatedEmail);

        /* store log */
        $timesheetLog->storeCheckEmailLog($validatedEmail, $result['uuid'], $result['full_name']);

        return response()->json($result);
    }
}
