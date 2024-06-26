<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Actions\Authentication\CheckEmailMentorTutorAction as AuthenticationCheckEmailMentorTutorAction;
use App\Actions\Logging\StoreLogAction as TimesheetLog;
use App\Actions\User\CreateNewTempUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\CheckEmailRequest;
use Illuminate\Http\JsonResponse;

class CheckEmailController extends Controller
{
    public function execute(
        CheckEmailRequest $request,
        AuthenticationCheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        CreateNewTempUserAction $createNewTempuserAction
        ): JsonResponse
    {
        $validated = $request->safe()->only(['email']);
        $validatedEmail = $validated['email'];

        $result = $checkEmailMentorTutorAction->execute($validatedEmail);

        $emailCheckingResult = $result['checkingResult'];
        $userRawInformation = $result['rawInformation'];

        $createNewTempuserAction->execute($userRawInformation);

        return response()->json($emailCheckingResult);
    }
}
