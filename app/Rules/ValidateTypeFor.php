<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidateTypeFor implements Rule
{
    public function passes($attribute, $value)
    {
        // Get the 'For' value from the request data
        $for = request('For');

        // Define a mapping of 'For' values to table names
        $tableNames = [
            'Leave' => 'leavetypes',
            'Expense' => 'expenses',
            'Loan' => 'loans',
            // Add more mappings as needed
        ];

        // Check if the 'For' value exists in the mapping
        if (array_key_exists($for, $tableNames)) {
            // Check if the 'type_id' exists in the corresponding table
            return DB::table($tableNames[$for])->where('id', $value)->exists();
        }

        return false; // 'For' value not found in the mapping
    }

    public function message()
    {
        return 'Invalid type_id for the selected For value.';
    }
}
