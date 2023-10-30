<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoresectionRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'department_id' => 'required|integer|exists:departments,id',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'section_head.exists' => 'The selected section head does not exist.',
            'department_name.exists' => 'The selected department does not exist.',
        ];
    }
}
