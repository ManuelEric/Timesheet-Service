<?php

namespace App\Actions\Request;

use App\Models\Ref_Program;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CancelRequestAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(Ref_Program $ref_program, string $cancellation_reason)
    {
        DB::beginTransaction();
        try {
            # not yet meaning unpaid
            $ref_program->cancellation_reason = $cancellation_reason;
            $ref_program->cancelled_at = Carbon::now();
            $ref_program->save();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $err_message = 'Failed to cancel request.';
            $this->responseService->storeErrorLog( $err_message, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()] );
            throw new HttpResponseException(
                response()->json([
                    'errors' => $err_message
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return $ref_program;
    }
}
