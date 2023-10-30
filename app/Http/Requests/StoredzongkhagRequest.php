<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoredzongkhagRequest extends FormRequest
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
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id', 
            'country_id' => 'required|exists:countries,id', 
            'status' => 'required|boolean',
        ];
    }
}
