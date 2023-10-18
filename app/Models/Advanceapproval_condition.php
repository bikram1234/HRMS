<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advanceapproval_condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_rule_id',
        'approval_type',
        'hierarchy_id',
        'employee_id',
        'MaxLevel',
        'AutoApproval',
        'formula',
    ];

    // Define the relationship to approval_rules
    // public function approvalRule()
    // {
    //     return $this->belongsTo(AdvanceApprovalRule::class, 'approval_rule_id');
    // }

    public function hierarchy()
    {
        return $this->belongsTo(Hierarchy::class, 'hierarchy_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function approvalRule()
{
    return $this->belongsTo(AdvanceApprovalRule::class, 'approval_rule_id');
}

}
