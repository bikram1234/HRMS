<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreappliedEncashmentRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'], // Add validation for user_id
            'number_of_days' => ['required', 'numeric', 'min:0.5'], // Add validation for no_of_days
            'amount' => ['required', 'numeric'],
            'remark' => ['nullable', 'string'],
        ];
    }
}
