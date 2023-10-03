<?php

// app/Models/Advance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'expense_type_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
