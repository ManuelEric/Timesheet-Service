<?php

namespace App\Services\User;

use App\Http\Traits\ConcatenateName;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateTempUserService
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
        $uuid = $userRawInformation['uuid'];
        $full_name = $userRawInformation['full_name'];
        $email = $userRawInformation['email'];
        $password = $userRawInformation['password'];

        /* check existing temp user */
        $tempUser = TempUser::where('email', $email)->first();

        $roles = array();
        foreach ($userRawInformation['roles'] as $detail)
        {
            /* create model temp_user_roles only if the role are inside acceptable roles */
            if ( in_array($detail['role_name'], ['Mentor', 'Tutor']) )
            {
                $role = $detail['role_name'];
                $tutor_subject = $detail['tutor_subject'];
                $fee_hours = $detail['feehours'] ?? 0;
                $fee_session = $detail['feesession'] ?? 0;

                $roleDetails[] = [
                    'role' => $role,
                    'tutor_subject' => $tutor_subject,
                    'fee_hours' => $fee_hours,
                    'fee_session' => $fee_session,
                ];
            }
        }

        



        /* if the user has existed on timesheet db */
        if ( $tempUser ) {
            /* update the password from CRMs */
            $tempUser->password = $password;
            $tempUser->save();           

            $tempUserId = $tempUser->id;


            /* update or create the temp_user_role */
            $this->storeOrUpdateRoles($tempUserId, $roleDetails);
        }
        

        /* stored the user into timesheet db */
        if ( !$tempUser ) {
    
            # initiate details for new temporary user
            $userDetails = [
                'uuid' => $uuid,
                'full_name' => $full_name,
                'email' => $email,
                'password' => $password,
            ];
    
            DB::beginTransaction();
            try {
                
                /* create a temporary user */
                $tempUser = TempUser::create($userDetails);
                $tempUserId = $tempUser->id;
                
                /* update or create the temp_user_role */
                $this->storeOrUpdateRoles($tempUserId, $roleDetails);
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

            return $tempUser;
        }
    }

    public function storeOrUpdateRoles(string $tempUserId, array $roleDetails)
    {
        foreach ($roleDetails as $detail) {
            $role = $detail['role'];
            $tutor_subject = $detail['tutor_subject'];
            $fee_hours = $detail['feehours'] ?? 0;
            $fee_session = $detail['feesession'] ?? 0;

            TempUserRoles::updateOrCreate(
                ['temp_user_id' => $tempUserId, 'role' => $role, 'tutor_subject' => $tutor_subject],
                ['fee_hours' => $fee_hours, 'fee_session' => $fee_session]
            );
        }
    }
}
