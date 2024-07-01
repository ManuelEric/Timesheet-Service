<?php

namespace App\Actions\Timesheet;

use App\Models\TempUser;
use App\Services\Authentication\CheckEmailMentorTutorService;
use App\Services\ResponseService;
use App\Services\User\CreateNewTempUserService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RegisterMentorTutorAction
{
    protected $checkEmailMentorTutorService;
    protected $createNewTempuserService;
    protected $responseService;

    public function __construct(
        CheckEmailMentorTutorService $checkEmailMentorTutorService,
        CreateNewTempUserService $createNewTempuserService,
        ResponseService $responseService,
        )
    {
        $this->checkEmailMentorTutorService = $checkEmailMentorTutorService;
        $this->createNewTempuserService = $createNewTempuserService;
        $this->responseService = $responseService;
    }

    public function execute(string $mentortutor_email): String
    {

        /* find mentor tutor in temp user */
        $foundMentortutor = TempUser::where('email', $mentortutor_email);
        if ( $foundMentortutor->exists() )
        {
            $selectedMentorOrTutorId = $foundMentortutor->first()->id;
        } 
        else 
        {
            /* create temp user if the selected mentor tutor doesnt exist in temp user */
            DB::beginTransaction();
            try {
                
                [$emailCheckingResult, $userRawInformation] = $this->checkEmailMentorTutorService->execute($mentortutor_email);
                $createdTempUser = $this->createNewTempuserService->execute($userRawInformation);
                $selectedMentorOrTutorId = $createdTempUser->id;

                DB::commit();

            } catch ( Exception $e ) {
                
                DB::rollBack();
                $errorMessage = 'Failed to store a mentor or tutor within assignment.';
                $this->responseService->storeErrorLog($errorMessage, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
                throw new HttpResponseException(
                    response()->json([
                        'errors' => $errorMessage,
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );

            } catch ( ConnectionException $e ) {

                DB::rollBack();
                $this->responseService->storeErrorLog('Connection to CRM has timed out.', $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
                throw new HttpResponseException(
                    response()->json([
                        'errors' => 'Connection timed out.',
                    ], JsonResponse::HTTP_GATEWAY_TIMEOUT)
                );
            }
            /* end */
        }        


        return $selectedMentorOrTutorId;
    }
}
