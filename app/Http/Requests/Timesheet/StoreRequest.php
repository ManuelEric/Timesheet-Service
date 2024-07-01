<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
            'ref_id' => 'required',
            'ref_id.*' => 'required|exists:ref_programs,id',
            'mentortutor_email' => 'required|email',
            'package_id' => 'required|exists:timesheet_packages,id',
            'detail_package' => 'required',
            'pic_id' => 'required|exists:users,id',
            'pic_id.*' => 'required|exists:users,id',
            'notes' => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ref_id.*.exists' => 'There seems to be a problem with the selected programs',
        ];
    }

    /**
     * Set the custom attributes for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'ref_id' => 'programs',
            'mentortutor_email' => 'mentor or tutor email',
        ];
    }
}
