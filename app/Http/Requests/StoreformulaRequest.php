<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreformulaRequest extends FormRequest
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

     public function rules()
{
        $rules = [
            'condition' => 'nullable|string|in:AND,OR,NOT',
            'field' => 'required|string|in:User,No. of Days',
            'operator' => 'required|string', // Add validation rules for operators
            'condition_id' => 'required|integer',
        ];

        // Determine the selected field
        $selectedField = $this->input('field');

        // Dynamically set the validation rules for "value" based on the selected field
        if ($selectedField === 'User') {
            $rules['employee_id'] = 'required|integer|exists:users,id';
        } elseif ($selectedField === 'No. of Days') {
            $rules['value'] = 'required|integer';
        } else {
            // Handle the default case here or add specific rules if needed
        }

        return $rules;
    }


}


