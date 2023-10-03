<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\leave_policy;

class Storeleave_policyRequest extends FormRequest
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
            Rule::unique('leave_policies', 'leave_id')->ignore($this->input('id'))
        ],
            'policy_name' => 'required|string',
            'policy_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
            'is_information_only' => 'nullable'
        ];
    }
}
