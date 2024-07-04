<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Actions\Authentication\CheckEmailMentorTutorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\CheckEmailRequest;
use App\Services\User\CreateNewTempUserService;
use Illuminate\Http\JsonResponse;

class CheckEmailController extends Controller
{
    public function execute(
        CheckEmailRequest $request,
        CheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        CreateNewTempUserService $createNewTempuserService
        ): JsonResponse
    {
        $validated = $request->safe()->only(['email']);
        $validatedEmail = $validated['email'];

        [$emailCheckingResult, $userRawInformation] = $checkEmailMentorTutorAction->execute($validatedEmail);

        $createNewTempuserService->execute($userRawInformation);

        return response()->json($emailCheckingResult);
    }
}
