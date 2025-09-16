<?php

namespace App\Actions\Authentication;

use App\Http\Traits\ConcatenateName;
use App\Http\Traits\HttpCall;
use App\Models\CRM\User as CRMUser;
use App\Services\Token\TokenService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CheckEmailMentorTutorActionModel
{
    use ConcatenateName;
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }
    
    public function execute(string $email)
    {
        $user = $this->fetchingUserInformation($email);
        if (!$user) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'The provided email does not exists.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        /* initialize the data */
        $id = $user['id'];
        $fullName = $this->concat($user['first_name'], $user['last_name']);
        $roles = $user['roles'];
        $emailExist = $user['email'] ? true : false;
        $hasPassword = $user['password'] ? true : false;

        /* manipulate the response */
        $checkingResult = [
            'uuid' => $id,
            'full_name' => $fullName,
            'email_exist' => $emailExist,
            'has_password' => $hasPassword,
        ];

        $rawInformation = [
            'uuid' => $id,
            'full_name' => $fullName,
            'email' => $user['email'],
            'phone' => $user['phone'],
            'password' => $user['password'],
            'roles' => collect($roles), // this will contains details of role such as data from tbl_user_subjects or user_streams
            'has_npwp' => $user['has_npwp'],
            'account_name' => $user['account_name'],
            'account_no' => $user['account_no'],
            'bank_name' => $user['bank_name'],
            'swift_code' => $user['swift_code'],
            'active' => $user['active'],
        ];

        $result = [$checkingResult, $rawInformation];

        return $result;
    }

    private function fetchingUserInformation($incomingEmail)
    {
        $query = CRMUser::query()->with([
            'educations' => function ($query) {
                $query->select('tbl_univ.univ_name', 'tbl_user_educations.created_at')->first();
            },
            'position' => function ($query) {
                $query->select('id', 'position_name');
            },
        ])->withAndWhereHas('roles', function ($query) {
            $query->whereIn('role_name', ['Mentor', 'External Mentor', 'Tutor', 'Editor'])->select('role_name');
        })->where('email', $incomingEmail);

        $result = $resultInArray = null;
        if ($query->exists()) {
            $result = $query->select('id', 'first_name', 'last_name', 'email', 'phone', 'password', 'npwp', 'position_id', 'active', 'account_name', 'account_no', 'bank_name')->
                selectRaw('(SELECT code FROM banks WHERE bank_name = users.bank_name) as swift_code')->
                first();

            // fetch the roles
            foreach ($result->roles as $role) {

                switch ($role->role_name) {
                    case 'Tutor':
                        $subjects_or_streams = $result->user_subjects->count() > 0 ? $result->user_subjects->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'subject' => $item->subject->name,
                                'curriculum' => $item->curriculum,
                                'start_date' => $item->start_date,
                                'end_date' => $item->end_date,
                                'year' => $item->year,
                                'grade' => $item->grade,
                                'fee_individual' => $item->fee_individual,
                                'head' => $item->head,
                                'fee_group' => $item->fee_group,
                                'additional_fee' => $item->additional_fee,
                                'agreement' => $item->agreement,
                            ];
                        }) : null;
                        break;
                    case 'External Mentor':
                        // for external mentor, retrieve from user_streams
                        $subjects_or_streams = $result->user_streams->count() > 0 ? $result->user_streams->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'stream' => $item->stream->stream_name,
                                'engagement_type_id' => $item->engagement_type_id,
                                'package' => $item->package,
                                'start_date' => $item->start_date,
                                'end_date' => $item->end_date,
                                'year' => $item->year,
                                'fee_individual' => $item->fee_individual,
                                'head' => $item->head,
                                'grade' => $item->grade,
                                'additional_fee' => $item->additional_fee,
                                'agreement' => $item->agreement,
                            ];
                        }) : null;
                        break;
                    case 'Editor':
                        // for editor, retrieve from editor_agreement
                        $subjects_or_streams = $result->editor_agreement->count() > 0 ? $result->editor_agreement->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'category' => $item->category,
                                'start_date' => $item->start_date,
                                'end_date' => $item->end_date,
                                'fee_individual' => $item->fee_individual,
                                'agreement' => $item->agreement,
                            ];
                        }) : null;
                        break;
                    default:
                        $subjects_or_streams = null;

                }

                $mappedRoles[] = [
                    'role_name' => $role->role_name,
                    'subjects' => $subjects_or_streams,
                ];
            }

            $resultInArray = $result->toArray();
            $resultInArray['roles'] = $mappedRoles;

            /* use unset in order to remove user_subjects or user_streams collection from array */
            unset($resultInArray['user_subjects']);
            unset($resultInArray['user_streams']);

            /* has_npwp used for determine value of tax */
            $resultInArray['has_npwp'] = $result->npwp ? true : false;

            return $resultInArray;
        }
    }
}
