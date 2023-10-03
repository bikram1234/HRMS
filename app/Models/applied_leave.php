<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applied_leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_id',
        'start_date',
        'end_date',
        'number_of_days',
        'remark',
    ];
    

    public function employee() {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function leavetype(){
        return $this->belongsTo(leavetype::class, 'leave_id');
    }
}
