<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TempUser\UpdateRequest as TempUserUpdateRequest;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MentorTutorsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* incoming request */
        $keyword = $request->only(['keyword', 'paginate', 'page', 'role']);
        $requestInhouse = $request->get('inhouse');
        $inhouse = $requestInhouse === "true" ? 1 : 0;

        /* call API to get all of the mentors and tutors */
        $request = Http::get( env('CRM_DOMAIN') . 'user/mentor-tutors', $keyword);
        $response = $request->json();

        $isPaginate = $keyword['paginate'] ?? false;

        /* only fetch the data in order to add inhouse item for each data */
        $mentortutorsCollection = $isPaginate == true ? $response['data'] : $response; 


        /* adding new items which is inhouse */
        $mappedResponse = collect($mentortutorsCollection)->map(function ($item) {

            $queryTempUser = TempUser::where('uuid', $item['uuid']);

            // return collect($item)->put('inhouse', $queryTempUser->exists() ? (bool) $queryTempUser->first()->inhouse : false);
            return array_merge($item, [
                'inhouse' => $queryTempUser->exists() ? (bool) $queryTempUser->first()->inhouse : false
            ]);
        });


        /* process the inhouse request just if using paginate param */
        if ( $requestInhouse !== NULL ) {

            $mappedResponse = $mappedResponse->where('inhouse', $inhouse)->toArray();
            $mappedResponse = array_values($mappedResponse);
        }

        

        
        /* combine the processed items with the pagination */
        $results = $isPaginate == true ? array_merge($response, ['data' => $mappedResponse]) : $mappedResponse;


        return response()->json($results);
    }

    public function update(
        TempUserUpdateRequest $request, 
        $tempUserUuid,
        ResponseService $responseService): JsonResponse
    {
        /* only receive updates inhouse column */
        $validatedInhouse = $request->safe()->only(['inhouse']);

        if ( !$tempUser = TempUser::where('uuid', $tempUserUuid)->first() )
        {
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

    /**
     * The component functions.
     */
    public function component(
        Request $request, 
        $mentorTutorsUuid,
        ): JsonResponse
    {
        $subjects = TempUserRoles::whereHas('temp_user', function ($query) use ($mentorTutorsUuid) {
            $query->where('uuid', $mentorTutorsUuid);
        })->get();

        $mappedSubjects = $subjects->map(function ($data) {
            return [
                'id' => $data->id,
                'role' => $data->role,
                'subject' => $data->tutor_subject,
            ];
        });

        return response()->json($mappedSubjects);
    }
}
