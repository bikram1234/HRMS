<?php

// app/Models/Policy.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = ['expense_type_id', 'name', 'description', 'start_date', 'end_date','status'];

    // public function expenseType()
    // {
    //     return $this->belongsTo(ExpenseType::class);
    // }
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }
    public function rateLimits()
    {
        return $this->hasMany(RateLimit::class, 'policy_id');
    }
    public function rateDefinitions()   
    {
        return $this->hasMany(RateDefinition::class);
    }
    public function enforcementOptions()
    {
        return $this->hasMany(EnforcementOption::class);
    }





}
