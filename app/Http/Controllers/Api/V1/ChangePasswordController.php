<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TempUser\PatchRequest as PaswordPatchRequest;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    public function patch(
        PaswordPatchRequest $request,
        ChangePasswordAction $changePasswordAction,
        ): JsonResponse
    {
        $incomingRequest = $request->safe()->only(['current_password', 'new_password']);

        $changePasswordAction->execute($incomingRequest);

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }
}
