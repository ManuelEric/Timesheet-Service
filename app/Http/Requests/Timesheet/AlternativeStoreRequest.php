<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AlternativeStoreRequest extends FormRequest
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
                //! TODOS = perlu di fetch agar kalau array ref_id.0 tidak perlu berbentuk array namun bisa langsung ref_id
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
            /* validation from mentor request */
            'clientprog_id' => 'nullable',
            'invoice_id' => 'required|string',
            'student_uuid' => 'required|string',
            'student_name' => 'required|string',
            'student_school' => 'nullable|string',
            'student_grade' => 'nullable|integer',
            'program_name' => 'required|string',
            'engagement_type' => 'required|exists:engagement_types,id',

            /* modified validation from timesheet request */
            'mentortutor_email' => 'required|email|exists:temp_users,email',
            'inhouse_id' => [
                'required',
                Rule::exists('temp_users', 'uuid')->where(function ($query) { #if selected uuid is the existing inhouse temp user
                    return $query->where('uuid', $this->input('inhouse_id'))->where('inhouse', 1);
                }) 
            ],
            'package_id' => [
                'required',
                'exists:timesheet_packages,id',
                //new CompatiblePackage($this->input('subject_id'),)
            ],
            'duration' => 'required|integer',
            'pic_id' => 'array',
            'pic_id.*' => 'required|exists:users,id',
            'notes' => 'nullable',
            'subject_id' => [
                'nullable',
                //new ExistSubjectPerTutormentor($this->input('mentortutor_email'))
            ],
            'individual_fee' => 'nullable',
            'tax' => 'required',
        ];
    }
}
