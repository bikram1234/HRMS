<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreleaveEncashmentApprovalRuleRequest extends FormRequest
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
            'For' => 'required|string|max:255',
            'type_id' => 'required|integer|exists:encashments,id',
            'RuleName' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|boolean'
        ];
    }
}
