<?php

namespace App\Actions\Payment;

use App\Models\Activity;
use App\Models\Cutoff;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CutoffAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(string $startDate, string $endDate)
    {
        DB::beginTransaction();
        try {

            /* select all activities between start_date and end_date */
            /* all of these activities going to be updated into paid activities */
            $rawQuery = Activity::query()->unpaid()->where('start_date', '>=', "{$startDate} 00:00:00")->where('end_date', '<=', "{$endDate} 23:59:59");
            $activities = $rawQuery->select('fee_hours', 'additional_fee', 'bonus_fee')->get();

            if ( count($activities) > 0 )
            {
                /* store cut-off as reference */
                $cutoff = new Cutoff();
                $cutoff->month = Carbon::parse($endDate)->format('F Y');
                $cutoff->from = $startDate;
                $cutoff->to = $endDate;
                $cutoff->save();
                
                /* execute */
                $rawQuery->update([
                    'status' => 1,
                    'cutoff_status' => 'paid',
                    'cutoff_ref_id' => $cutoff->id
                ]);                
            }
            DB::commit();
        } catch (Exception $err) {

            DB::rollBack();
            $errorMessage = 'Failed to do a cut-off';
            $this->responseService->storeErrorLog($errorMessage, $err->getMessage(), ['file' => $err->getFile(), 'error_line' => $err->getLine()]);
            throw new HttpResponseException(
                response()->json([
                    'errors' => $errorMessage
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return $activities;
    }
}
