<?php

namespace App\Actions\Request;

use App\Models\NewRequest;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateRequestAction 
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }
    
    public function execute(array $request): array
    {
        $authUser = auth('sanctum')->user();

        DB::beginTransaction();
        try {

            $requestDetails = [
                'mentor_id' => $authUser->id,
                'clientprog_id' => $request['clientprog_id'],
                'invoice_id' => $request['invoice_id'],
                'student_uuid' => $request['student_uuid'],
                'student_name' => $request['student_name'],
                'student_school' => $request['student_school'],
                'student_grade' => $request['student_grade'],
                'program_name' => $request['program_name'],
                'engagement_type_id' => $request['engagement_type'],
                'notes' => $request['notes']
            ];
    
            $newRequest = NewRequest::create($requestDetails);
            DB::commit();
            
        } catch (Exception $err) {
            
            DB::rollBack();
            $errors = 'Failed to create new request.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => []
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
            
        }

        return $newRequest->toArray();
    }
}
