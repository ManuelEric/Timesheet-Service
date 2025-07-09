<?php

namespace App\Services\User;

use App\Http\Traits\ConcatenateName;
use App\Models\Curriculum;
use App\Models\Package;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTempUserService
{
    use ConcatenateName;
    protected $responseService;
    protected $externalMentorService;

    public function __construct(ResponseService $responseService, ExternalMentorService $externalMentorService)
    {
        $this->responseService = $responseService;
        $this->externalMentorService = $externalMentorService;
    }

    public function execute(array $userRawInformation)
    {
        /* fetch user raw information */
        $uuid = $userRawInformation['uuid'];
        $full_name = $userRawInformation['full_name'];
        $email = $userRawInformation['email'];
        $phone = $userRawInformation['phone'];
        $password = $userRawInformation['password'];
        $has_npwp = $userRawInformation['has_npwp'];

        /* check existing temp user */
        $tempUser = TempUser::where('email', $email)->first();

        $roles = array();
        /* fetch from detail information of `roles` from CRM's endpoint auth/email/check */
        /* $userRawInformation['roles'] will contains detail of user_subject as tutor or user_streams as external mentor */
        foreach ($userRawInformation['roles'] as $detail)
        {
            /* create model temp_user_roles only if the role are inside acceptable roles */
            if ( in_array($detail['role_name'], ['Mentor', 'External Mentor', 'Tutor']) )
            {
                $role_name = $detail['role_name'];
                $subjects = $detail['subjects']; // will contains detail of user_subject or user_streams

                /* retrieve and create an array for details of user_subject or user_stream */
                switch ($role_name) {
                    /* when role_name is mentor then no need to add the details because they won't have the subject or stream */
                    case "Mentor":
                        $roleDetails[] = [
                            'role' => $role_name
                        ];
                        break;
                    /* when role_name is external mentor then add the details from user_stream */
                    case "External Mentor":

                        foreach ($subjects as $subject) {
                            $roleDetails[] = [
                                'role' => $role_name,
                                'stream' => $subject['stream'],
                                'engagement_type' => $subject['engagement_type_id'],
                                'package' => $subject['package'],
                                'start_date' => $subject['start_date'],
                                'end_date' => $subject['end_date'],
                                'year' => $subject['year'],
                                'fee_individual' => $subject['fee_individual'] ?? 0,
                                'head' => $subject['head'],
                                'grade' => $subject['grade'],
                                'additional_fee' => $subject['additional_fee'] ?? 0,
                                'tax' => 2.5
                            ];
                        }
                        break;
                    /* when role_name is tutor then add the details from user_subject */
                    case "Tutor":
                        foreach ( $subjects as $subject  ) {            
                            $roleDetails[] = [
                                'role' => $role_name,
                                'subject' => $subject['subject'],
                                'curriculum_id' => Curriculum::where('alias', $subject['curriculum'])->first()->id ?? null,
                                'start_date' => $subject['start_date'],
                                'end_date' => $subject['end_date'],
                                'year' => $subject['year'], # an indicator that allow this user to be a tutor for only student with choosen year
                                'head' => $subject['head'],
                                'additional_fee' => $subject['additional_fee'] ?? 0,
                                'grade' => $subject['grade'],
                                'fee_individual' => $subject['fee_individual'] ?? 0,
                                'fee_group' => $subject['fee_group'] ?? 0,
                                'tax' => 2.5
                            ];
                        }
                        break;
                }
            }
        }


        /* if the user is exists in timesheet database then update the detail of user and store/update the roles detail */
        if ( $tempUser ) {
            DB::beginTransaction();
            try {

                /* update the personal information from CRMs, in order to the data in timesheet db stay updated */
                $tempUser->uuid = $uuid;
                $tempUser->full_name = $full_name;
                $tempUser->email = $email;
                $tempUser->phone = $phone;
                $tempUser->has_npwp = $has_npwp;
                $tempUser->save();
                $tempUserId = $tempUser->id;
    
                # because managing timesheet now Kak Steven can also input the subject and fees
                # guess, it doesn't used it anymore but I'll put it here just in case needed
                /* update or create the temp_user_role */
                $this->storeOrUpdateRoles($tempUserId, $roleDetails);
                DB::commit();
            } catch (Exception $err) {
                DB::rollBack();
                $errors = 'Failed to update existing temporary user.';
                $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                    'file' => $err->getFile(),
                    'error_line' => $err->getLine(),
                    'value' => [
                        'uuid' => $uuid,
                        'full_name' => $full_name,
                        'email' => $email,
                        'phone' => $phone,
                        'has_npwp' => $has_npwp,
                        'roles' => $roleDetails
                    ]
                ]);

                throw new HttpResponseException(
                    response()->json([
                        'errors' => $errors
                    ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                );
            }
            return $tempUser;
        }
        

        /* if the user is not exists then stored the user into timesheet db including the detail of role */
        $userDetails = [
            'uuid' => $uuid,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'has_npwp' => $has_npwp,
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
            $errors = 'Failed to store new temporary user.';
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

    public function storeOrUpdateRoles(string $tempUserId, array $roleDetails)
    {
        foreach ($roleDetails as $detail) 
        {
            switch ($detail['role']) {
                case "Tutor":
                    $role = $detail['role'];
                    $tutor_subject = $detail['subject'] ?? null;
                    $curriculum_id = $detail['curriculum'] ?? null;
                    $start_date = $detail['start_date'] ?? null;
                    $end_date = $detail['end_date'] ?? null;
                    $year = $detail['year'] ?? null;
                    $head = $detail['head'] ?? null;
                    $additional_fee = $detail['additional_fee'] ?? 0;
                    $grade = $detail['grade'] ?? null;
                    $fee_individual = $detail['fee_individual'] ?? 0;
                    $fee_group = $detail['fee_group'] ?? 0;
                    $tax = $detail['tax'] ?? 0;
                    TempUserRoles::updateOrCreate(
                        ['temp_user_id' => $tempUserId, 'role' => $role, 'tutor_subject' => $tutor_subject, 'curriculum_id' => $curriculum_id],
                        [
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'year' => $year,
                            'head' => $head,
                            'additional_fee' => $additional_fee,
                            'grade' => $grade,
                            'fee_individual' => $fee_individual,
                            'fee_group' => $fee_group,
                            'tax' => $tax
                        ]
                    );
                    break;

                case "External Mentor":
                    TempUserRoles::updateOrCreate(
                        [
                            'temp_user_id' => $tempUserId, 
                            'role' => $detail['role'], 
                            'ext_mentor_stream' => $detail['stream'], 
                            'package_id' => Package::where('type_of', $detail['package'])->first()->id, // because the data from crm will be string 
                            'engagement_type_id' => $detail['engagement_type']
                        ],
                        [
                            'start_date' => $detail['start_date'],
                            'end_date' => $detail['end_date'],
                            'head' => $detail['head'],
                            'additional_fee' => $detail['additional_fee'],
                            'grade' => $detail['grade'],
                            'fee_individual' => $detail['fee_individual'],
                            'tax' => $detail['tax']
                        ]
                    );
                    break;
            }

            // default
            TempUserRoles::updateOrCreate(
                ['temp_user_id' => $tempUserId, 'role' => $detail['role']],
                []
            );
            
        }
    }
}
