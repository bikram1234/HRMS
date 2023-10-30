<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leaveEncashmentApprovalRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'For',
        'type_id',
        'RuleName',
        'start_date',
        'end_date',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(encashment::class, 'type_id');
    }

     // Define the relationship to approval_conditions
     public function encashmentApprovalConditions()
     {
         return $this->hasMany(leaveEncashmentApprovalCondition::class);
     }
}
