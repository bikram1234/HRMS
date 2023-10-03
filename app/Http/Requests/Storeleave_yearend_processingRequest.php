<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Storeleave_yearend_processingRequest extends FormRequest
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
            // 'leave_id' => 'required|exists:leavetypes,id',
            'leave_id' => [
                'required',
                'integer',
                'exists:leavetypes,id',
                Rule::unique('leave_yearend_processings', 'leave_id')->ignore($this->input('id'))
            ],
            'allow_carryover' => 'boolean',
            'carryover_limit' => 'integer|min:0',
            'payat_yearend' => 'boolean',
            'min_balance' => 'integer|min:0',
            'max_balance' => 'integer',
            'carryforward_toEL' => 'boolean',
            'carryforward_toEL_limit' => 'integer|min:0',
        ];
    }
}
