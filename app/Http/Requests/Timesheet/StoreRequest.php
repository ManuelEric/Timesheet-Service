<?php

namespace App\Http\Requests\Timesheet;

use App\Models\TempUser;
use App\Rules\ExistSubjectPerTutormentor;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
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
                //! TODOS = perlu di fetch agar kalau array ref_id.0 tidak perlu berbentuk array namun bisa langsung ref_id
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        switch ( $this->method() )
        {
            case "POST":
                return $this->store();

            case "PUT":
                return $this->update();

            case "PATCH":
                return $this->patch();
        }
    }

    public function store(): array
    {
        return [
            'ref_id' => 'required|array',
            'ref_id.*' => [
                'required', 
                'exists:ref_programs,id',
                //new MatchingProgramName,
                //new SameGrade($this->input('mentortutor_email'), $this->input('subject_id'), $this->input('package_id')),
                //new CompatibleProgram($this->input('subject_id')),
            ],
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
                // new ExistSubjectPerTutormentor($this->input('mentortutor_email'))
            ],
            'subject_name' => 'nullable',
            'individual_fee' => 'nullable',
            'tax' => 'required',
            'curriculum_id' => 'nullable|exists:curriculums,id'
        ];
    }

    public function update(): array
    {
        return [
            'ref_id' => 'required|array',
            'ref_id.*' => [
                'required', 
                'exists:ref_programs,id',
                //new MatchingProgramName,
                //new SameGrade($this->input('mentortutor_email'), $this->input('subject_id'), $this->input('package_id')),
                //new CompatibleProgram($this->input('subject_id')),
            ],
            'mentortutor_email' => 'required|email|exists:temp_users,email',
            'inhouse_id' => [
                'required',
                Rule::exists('temp_users', 'uuid')->where(function ($query) { #if selected uuid is the existing inhouse temp user
                    return $query->where('uuid', $this->input('inhouse_id'))->where('inhouse', 1);
                }) 
            ],
            'package_id' => 'required|exists:timesheet_packages,id',
            'duration' => 'required|integer',
            'pic_id' => 'array',
            'pic_id.*' => 'required|exists:users,id',
            'notes' => 'nullable',
            'subject_id' => [
                'nullable',
                Rule::exists('temp_user_roles', 'id')->where(function ($query) { #if selected subject is same with tempuser's
                    $tempUser = TempUser::where('email', $this->input('mentortutor_email'))->first();
                    return $query->where('id', $this->input('subject_id'))->where('temp_user_id', $tempUser->id);
                })
            ],
            'individual_fee' => 'nullable',
            'tax' => 'nullable',
        ];
    }

    public function patch(): array
    {
        return [
            'mentortutor_email' => 'required|email|exists:temp_users,email',
            'subject_id' => [
                'nullable',
                Rule::exists('temp_user_roles', 'id')->where(function ($query) { #if selected subject is same with tempuser's
                    $tempUser = TempUser::where('email', $this->input('mentortutor_email'))->first();
                    return $query->where('id', $this->input('subject_id'))->where('temp_user_id', $tempUser->id);
                })
            ]
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
            'mentortutor_email' => 'mentor/tutor email',
            'inhouse_id' => 'inhouse mentor/tutor',
            'package_id' => 'package',
            'pic_id' => 'PIC',
            'subject_id' => 'subject'
        ];
    }
}
