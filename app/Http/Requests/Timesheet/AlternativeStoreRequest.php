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
     * Set the data before validation
     */
    public function prepareForValidation()
    {
        // Get the 'ref_details' array from the request
        $refDetails = $this->input('ref_details', []); // Use [] as default if not present

        // Use Laravel collection to map over each detail and add/modify the category
        $modifiedRefDetails = collect($refDetails)->map(function ($detail) {
            $detail['category'] = 'b2c';
            return $detail;
        })->all(); // Convert back to array if needed, or keep as collection

        // Merge the modified ref_details back into the request
        $this->merge([
            'ref_details' => $modifiedRefDetails,
        ]);
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
            'ref_details' => 'required|array',
            'ref_details.*' => 'required',
            'ref_details.*.clientprog_id' => 'required',
            'ref_details.*.invoice_id' => 'nullable',
            'ref_details.*.student_uuid' => 'required|string',
            'ref_details.*.student_first_name' => 'required|string',
            'ref_details.*.student_last_name' => 'nullable|string',
            'ref_details.*.student_school' => 'nullable|string',
            'ref_details.*.student_grade' => 'nullable|integer',
            'ref_details.*.program_name' => 'required|string',
            'ref_details.*.require' => 'required|string',
            'ref_details.*.package' => 'nullable|string',
            'ref_details.*.curriculum' => 'nullable|string',
            'ref_details.*.engagement_type' => 'required|exists:engagement_types,id',

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
