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
        'level1',
        'level2',
        'level3',
        'status'
    ];
    

    public function employee() {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function leavetype(){
        return $this->belongsTo(leavetype::class, 'leave_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
