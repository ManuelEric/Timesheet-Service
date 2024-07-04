<?php

namespace App\Actions\Timesheet;

use App\Models\Package;
use App\Models\Ref_Program;
use App\Models\Timesheet;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateTimesheetAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(array $ref_programId, array $storePackageDetails, ?string $notes, array $picIds, string $mentortutorId)
    {
        /* define submitted package variables */
        $packageId = $storePackageDetails['validatedPackageId'];
        $duration = $storePackageDetails['validatedDuration'];

        /* fetch package details from db by submitted package ID */
        $packageMaster = Package::find($packageId);
        $packageType = $packageMaster->type_of;
        $detailPackage = $packageMaster->package;

        /* merge variables into array that going to be stored into timesheet */
        $timesheetDetails = [
            'package_id' => $packageId,
            'package_type' => $packageType,
            'detail_package' => $detailPackage,
            'duration' => $duration,
            'notes' => $notes,
        ];
        
        DB::beginTransaction();
        try {

            $createdTimesheet = Timesheet::create($timesheetDetails);
            $createdTimesheet->handle_by()->attach($mentortutorId, ['active' => true]);
            $createdTimesheet->admin()->attach($picIds);

        } catch (Exception $e) {

            $errorMessage = "There was an error while creating a timesheet.";
            $this->responseService->storeErrorLog($errorMessage, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
            throw new HttpResponseException(
                response()->json([
                    'errors' => $errorMessage
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }


        /* insert timesheet into the success-program */
        $ref_Programs = Ref_Program::doesntHave('timesheet')->whereIn('id', $ref_programId)->get();
        
        /* check if there are ref_program that doesn't have timesheet */
        if ( count($ref_Programs) === 0 )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Each of the selected program already has a timesheet.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
                
        try {

            foreach ($ref_Programs as $program)
            {
                $program->timesheet_id = $createdTimesheet->id;
                $program->save();
            }
            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            $errorMessage = "There was an error while updating the ref programs.";
            $this->responseService->storeErrorLog($errorMessage, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
            return response()->json([
                'errors' => $errorMessage
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        }
    }
}
