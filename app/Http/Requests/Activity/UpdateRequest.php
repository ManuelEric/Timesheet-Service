<?php

namespace App\Http\Requests\Activity;

use App\Rules\ExistStartDateActivities;
use App\Rules\LimitedDurationActivity;
use App\Rules\StatusActivity;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'message' => "",
                'errors' => $errors
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $timesheet_id = $this->route('timesheet');
        $activity_id = $this->route('activity');
        $input_startDate = $this->input('start_date');
        $input_endDate = $this->input('end_date');
        
        return [
            'activity' => 'required',
            'description' => 'nullable',
            'start_date' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                new ExistStartDateActivities('PUT', $timesheet_id, $activity_id),
            ],
            'end_date' => [
                'nullable', 
                'date', 
                'date_format:Y-m-d H:i:s',
                'after_or_equal:date',
            ],
            'meeting_link' => 'nullable|active_url',
            'status' => [
                'nullable', 
                'integer',
                new StatusActivity($input_endDate)
            ],
        ];
    }

    /**
     * Get the validation attributes.
     * 
     */
    public function attributes(): array
    {
        return [
            'start_date' => 'start date',
            'end_date' => 'end date',
            'meeting_link' => 'meeting link',
        ];
    }
}
