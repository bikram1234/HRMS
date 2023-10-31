<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreholidayRequest extends FormRequest
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
            'name' => 'required|string',
            'holiday_id' => 'required|exists:holidaytypes,id',
            'region_id' => 'required|array', // Ensure region_id is an array
            'region_id.*' => 'exists:regions,id', // Validate each region_id item
            'optradioholidayfrom' => 'in:First Half,Second Half',
            'optradioholidaylto' => 'in:First Half,Second Half',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:1,0',
            'number_of_days' => 'required|integer',
            'description' => 'nullable|string', 
        ];
    }
}
