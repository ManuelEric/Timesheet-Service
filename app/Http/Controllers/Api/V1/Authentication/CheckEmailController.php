<?php

namespace App\Http\Controllers\Api\V1\Authentication;

use App\Actions\Authentication\CheckEmailMentorTutorAction;
use App\Services\User\CreateTempUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\CheckEmailRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CheckEmailController extends Controller
{
    public function execute(
        CheckEmailRequest $request,
        CheckEmailMentorTutorAction $checkEmailMentorTutorAction,
        CreateTempUserService $createTempUserService
    ): JsonResponse {
        $validated = $request->safe()->only(['email']);
        $validatedEmail = $validated['email'];

        [$emailCheckingResult, $userRawInformation] = $checkEmailMentorTutorAction->execute($validatedEmail);

        $createTempUserService->execute($userRawInformation);

        Log::notice('Successfully checked the email');
        return response()->json($emailCheckingResult);
    }
}
