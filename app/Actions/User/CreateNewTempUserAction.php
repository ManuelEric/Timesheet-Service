<?php

namespace App\Actions\User;

use App\Http\Traits\ConcatenateName;
use App\Models\TempUser;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CreateNewTempUserAction
{
    use ConcatenateName;
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(array $userRawInformation)
    {
        /* fetch user raw information */
        $full_name = $userRawInformation['full_name'];
        $email = $userRawInformation['email'];
        $password = $userRawInformation['password'];
        $roles = $userRawInformation['roles'];
         
        /* check existing temp user */
        $tempUser = TempUser::where('email', $email)->first();

        /* stored the user into timesheet db */
        if ( !$tempUser ) {

            /* create temporary mentor / tutor */
            # checking his/her roles from CRM in order to match the roles on timesheet app
            $acceptedRole = '';
            $acceptedRolesInTimesheet = ['Mentor', 'Tutor'];
            foreach ($roles as $role) 
            {
                if ( array_search($role['role_name'], $acceptedRolesInTimesheet) !== false ) 
                {
                    $acceptedRole = $role['role_name'];
                    break;
                }
            }
    
            if ( !$acceptedRole ) {
                $this->responseService->storeErrorLog('Invalid role provided.', 'Failed to continue to process create temporary user since the provided user has no acceptable roles');
    
                throw new HttpResponseException(
                    response()->json([
                        'errors' => 'Invalid role provided.'
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
            }
    
            # initiate details for new temporary user
            $userDetails = [
                'full_name' => $full_name,
                'email' => $email,
                'password' => $password,
                'role' => strtolower($acceptedRole),
            ];
    
            DB::beginTransaction();
            try {
                
                /* create a temporary user */
                $tempUser = TempUser::create($userDetails);
                DB::commit();
            
            } catch (Exception $err) {
    
                DB::rollBack();
                $errors = 'Failed to create new temporary user.';
                $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                    'file' => $err->getFile(),
                    'error_line' => $err->getLine(),
                    'value' => $userDetails
                ]);
    
                throw new HttpResponseException(
                    response()->json([
                        'errors' => $errors
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
    
            }
        }
    }
}
