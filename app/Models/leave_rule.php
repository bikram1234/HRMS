<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_rule extends Model
{
    use HasFactory;

    protected $fillable = [
        "leave_id",
        "grade_id",
        "duration",
        "uom",
        "start_date",
        "end_date",
        "islossofpay",
        "employee_type",
        "status",
    ];

    public function grade() {
        return $this->belongsTo(grade::class, 'grade_id');
    }

    public function leaves()
    {
        return $this->hasMany(LeaveType::class); 
    }


}
