<?php

namespace App\Http\Controllers\Api\V1\MentorTutor;

use App\Http\Controllers\Controller;
use App\Http\Requests\TempUser\UpdateRequest as TempUserUpdateRequest;
use App\Http\Requests\TempUser\PatchRequest as TempUserPatchRequest;
use App\Http\Traits\HttpCall;
use App\Models\TempUser;
use App\Services\ResponseService;
use App\Services\Token\TokenService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index(Request $request): JsonResponse
    {
        /* incoming request */
        $search = $request->only(['keyword', 'role', 'inhouse']);
        $additionalSearch = $request->only(['paginate']);

        /* manage the variables of additional search */
        $isPaginate = $additionalSearch['paginate'] ?? false;

        $tutormentors = TempUser::with('roles')->onSearch($search)->get();

        /* in order to grouped the roles by role_name, we need to mapping the data */
        $mappedTutormentors = $tutormentors->map(function ($item) {
            $profile = [
                'id' => $item->id,
                'uuid' => $item->uuid,
                'full_name' => $item->full_name,
                'phone' => $item->phone,
                'email' => $item->email,
                'inhouse' => $item->inhouse,
                'last_activity' => $item->last_activity,
                'roles' => new Collection()
            ];

            [$mentorDetail, $tutorDetail] = $item->roles->partition(function ($value) {
                return $value->role == 'Mentor';
            });
        
            if ($mentorDetail->count() > 0)
            {
                $profile['roles']->push([
                    'name' => 'Mentor',
                    'subjects' => array_values($mentorDetail->all())
                ]);
            }

            if ($tutorDetail->count() > 0)
            {
                $profile['roles']->push([
                    'name' => 'Tutor', 
                    'subjects' => array_values($tutorDetail->all())
                ]);
            }            

            return $profile;
        });

        $results = $isPaginate == true ? $mappedTutormentors->paginate(10) : $mappedTutormentors;

        return response()->json($results);
    }

    public function update(
        TempUserUpdateRequest $request,
        $tempUserUuid,
        ResponseService $responseService
    ): JsonResponse {
        /* only receive updates inhouse column */
        $validatedInhouse = $request->safe()->only(['inhouse']);

        if (!$tempUser = TempUser::where('uuid', $tempUserUuid)->first()) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Invalid code provided.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        DB::beginTransaction();
        try {

            $tempUser->update($validatedInhouse);
            DB::commit();
        } catch (Exception $err) {

            DB::rollBack();
            $errors = 'Failed to change the inhouse status.';
            $responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => $validatedInhouse
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return response()->json([
            'message' => 'The selected mentor/tutor has been set to inhouse'
        ]);
    }

    public function patch(TempUserPatchRequest $request)
    {
        $incomingRequest = $request->safe()->only(['current_password', 'new_password']);
        $validatedCurrentPassword = $incomingRequest['current_password'];
        $validatedNewPassword = $incomingRequest['new_password'];

        $authUser = auth('sanctum')->user();
        $currentAuthPassword = $authUser->password;

        /* check if the passwords matches */
        if ( !Hash::check($validatedCurrentPassword, $currentAuthPassword) )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Current password is Invalid.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        /* check if the current password and the new password are same */
        if ( strcmp($validatedCurrentPassword, $validatedNewPassword) == 0 )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'New Password cannot be same as your current password.'
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        $authUser->password = Hash::make($validatedNewPassword);
        $authUser->save();

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }
}
