<?php

namespace App\Http\Controllers\Api\V1\MentorTutor;

use App\Http\Controllers\Controller;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function patch(
        TempUser $tempUser, 
        TempUserRoles $roles,
        Request $request,
        ResponseService $responseService,
        ): JsonResponse
    {
        $request->validate([
            'fee_individual' => 'required', // user will input nett fee
        ]);

        $validated = $request->only(['fee_individual']);
        
        DB::beginTransaction();
        try {
            $nett_fee = $validated['fee_individual'];
            $tax = ($validated['fee_individual'] * 2.5) / 100;
            $gross_fee = $nett_fee + $tax;
            $roles->fee_individual = $gross_fee; 

            $roles->save();
            DB::commit();
        } catch (Exception $err) {
            DB::rollBack();
            $errors = 'Failed to change the her/his fee.';
            $responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => $validated
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return response()->json([
            'message' => 'His/her fee has been updated.'
        ]);
    }
}
