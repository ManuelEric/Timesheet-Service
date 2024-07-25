<?php

namespace App\Http\Requests\Payment;

use App\Rules\CutoffMonth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CutoffExportRequest extends FormRequest
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

    public function all($keys = null)
    {
        $data = parent::all();
        $data['timesheet_id'] = $this->route('timesheet');
        $data['cutoff_date'] = $this->route('cutoff_date');
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'timesheet_id' => 'required|exists:timesheets,id',
            'cutoff_date' => [
                'required', 
                'date', 
                new CutoffMonth
            ]
        ];
    }

    /**
     * Get the validation attributes.
     * 
     */
    public function attributes(): array
    {
        return [
            'timesheet_id' => 'timesheet identifier',
            'cutoff_date' => 'cut-off date',
        ];
    }
}
