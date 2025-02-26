<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Request\CreateRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StoreRequest;
use App\Models\NewRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    public function index(): JsonResponse
    {
        $new_requests = NewRequest::with([
                'engagementType' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->
            orderBy('created_at', 'desc')->
            select([
                'student_name', 'student_school', 'student_grade', 'engagement_type_id', 'notes'
            ])->get();

        $mapped_new_request = $new_requests->map(function ($item) {
            return [
                'student_name' => $item->student_name,
                'student_school' => $item->student_school,
                'student_grade' => $item->student_grade,
                'engagement_type' => $item->engagementType->name
            ];
        });

        return response()->json($mapped_new_request->paginate());
    }

    public function store(
        StoreRequest $request,
        CreateRequestAction $createRequestAction)
    {
        $validated = $request->safe()->only([
            'clientprog_id',
            'invoice_id',
            'student_uuid',
            'student_name',
            'student_school',
            'student_grade',
            'program_name',
            'engagement_type',
            'notes',
        ]);

        $newRequest = $createRequestAction->execute($validated);
        return response()->json([
            'message' => 'Request has created successfully.',
            'data' => $newRequest
        ]);
    }
}
