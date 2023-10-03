<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storeapproval_conditionRequest extends FormRequest
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
            'approval_rule_id' => 'required|integer|unique:approval_conditions|exists:approval_rules,id',
            'approval_type' => 'required|in:Hierarchy,Single User,Auto Approval',
            'hierarchy_id' => $this->input('approval_type') === 'Hierarchy' ? 'required|integer' : 'nullable',
            'employee_id' => $this->input('approval_type') === 'Single User' ? 'required|integer' : 'nullable',
            'MaxLevel' => $this->input('approval_type') === 'Hierarchy' ? 'required|string' : 'nullable',
            'AutoApproval' => $this->input('approval_type') === 'Auto Approval' ? 'boolean' : 'nullable',
        ];
    }
}
