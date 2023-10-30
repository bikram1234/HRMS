<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approval_condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_rule_id',
        'approval_type',
        'hierarchy_id',
        'employee_id',
        'MaxLevel',
        'AutoApproval',
    ];

    // Define the relationship to approval_rules
    public function approvalRule()
    {
        return $this->belongsTo(ApprovalRule::class, 'approval_rule_id');
    }

    public function hierarchy()
    {
        return $this->belongsTo(Hierarchy::class, 'hierarchy_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
