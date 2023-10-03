<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Storeleave_planRequest extends FormRequest
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
            // 'leave_id' => 'required|integer|exists:leavetypes,id|unique:leave_plan,leave_id,' . $id,
            'leave_id' => [
                'required',
                'integer',
                'exists:leavetypes,id',
                Rule::unique('leave_plans', 'leave_id')->ignore($this->input('id'))
            ],
            'attachment_required' => 'nullable',
            'gender' => 'required|string', 
            'leave_year' => 'required|string', 
            'credit_frequency' => 'required|string', 
            'credit' => 'required|string', 
            'include_public_holidays' => 'nullable',
            'include_weekends' => 'nullable',
            'can_be_clubbed_with_el' => 'nullable',
            'can_be_clubbed_with_cl' => 'nullable',
            'can_be_half_day' => 'nullable',
            'probation_period' => 'nullable',
            'regular_period' => 'nullable',
            'contract_period' => 'nullable',
            'notice_period' => 'nullable',
        ];
    }
}
