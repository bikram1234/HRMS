<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\approval_condition; 

class AdvanceApprovalRule extends Model
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
        return $this->belongsTo(Advance::class, 'type_id');
    }
     // Define the relationship to approval_conditions
    // public function approvalConditions()
    // {
    //     return $this->hasMany(Advanceapproval_condition::class);
    // }
    public function approvalConditions()
{
    return $this->hasMany(Advanceapproval_condition::class, 'approval_rule_id');
}

}
