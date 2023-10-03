<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_policy extends Model
{
    use HasFactory;

    protected $fillable=[
        'leave_id',
        'policy_name',
        'policy_description',
        'start_date',
        'end_date',
        'status',
        'is_information_only',
    ];

    public function leavetype()
    {
        return $this->belongsTo(leavetype::class, 'leave_id');
    }
}
