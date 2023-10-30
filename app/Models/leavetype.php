<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leavetype extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_code',
        'status'
    ];


    public function leaveRules()
    {
        return $this->hasMany(leave_rule::class, 'leave_id');
    }

}
