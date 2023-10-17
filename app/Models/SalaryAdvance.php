<?php

// app/Models/SalaryAdvance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryAdvance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'advance_type_id', 'advance_no', 'date', 'amount', 'emi_count', 'deduction_period', 'purpose', 'upload_file', 'remark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function advanceType()
    {
        return $this->belongsTo(Advance::class, 'advance_type_id');
    }
}
