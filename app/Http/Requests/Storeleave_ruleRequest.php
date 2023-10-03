<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Storeleave_ruleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'leave_id' => 'required|integer|exists:leavetypes,id',
            'leave_id' => [
                'required',
                'integer',
                'exists:leavetypes,id',
                Rule::unique('leave_rules', 'leave_id')->ignore($this->input('id'))
            ],
            'grade_id' => 'required|exists:grades,id',
            'duration' => 'required|integer|min:1',
            'uom' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'islossofpay' => 'boolean',
            'employee_type' => 'required|string|max:255',
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'grade_id.exists' => 'The selected grade does not exist.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}
