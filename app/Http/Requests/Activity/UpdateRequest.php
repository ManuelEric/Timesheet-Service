<?php

namespace App\Http\Requests\Activity;

use App\Rules\ExistStartDateActivities;
use App\Rules\StatusActivity;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
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
        return [
            'activity' => 'required',
            'description' => 'nullable',
            'start_date' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                new ExistStartDateActivities('PUT', $this->route('timesheet'), $this->route('activity'))
            ],
            'end_date' => 'nullable|date|date_format:Y-m-d H:i:s|after:start_date',
            'meeting_link' => 'required|active_url',
            'status' => [
                'nullable', 
                'integer',
                new StatusActivity($this->input('end_date'))
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
