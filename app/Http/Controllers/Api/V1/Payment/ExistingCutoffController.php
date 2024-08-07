<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StoreToExisingCutoffRequest;
use App\Models\Activity;
use App\Models\Cutoff;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExistingCutoffController extends Controller
{
    public function store(StoreToExisingCutoffRequest $request): JsonResponse
    {
        $validated = $request->safe()->only(['activity_id', 'start_date', 'end_date']);

        $validatedActivityIds = $validated['activity_id'];
        $validatedStartDate = $validated['start_date'];
        $validatedEndDate = $validated['end_date'];
        $validatedMonth = Carbon::parse($validatedStartDate)->format('F Y');

        /* get the cut off id by requested date */
        $cutoff = Cutoff::where('month', $validatedMonth)->inBetwen($validatedStartDate, $validatedEndDate)->first();
        $cutoffId = $cutoff->id;
        
        DB::beginTransaction();
        try {

            /* update the selected activity */
            Activity::whereIn('id', $validatedActivityIds)->update([
                'status' => 1,
                'cutoff_status' => 'paid',
                'cutoff_ref_id' => $cutoffId
            ]);
            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'An error occurred while trying to add the selected activity to the cutoff.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );

        }

        $totalActivity = count($validatedActivityIds);

        return response()->json([
            'message' => "{$totalActivity} Activities has been added successfully into the cut-off of {$validatedMonth}"
        ]);
    }
}
