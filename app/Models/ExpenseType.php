<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'status'];


    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function rateLimits()
    {
        return $this->hasManyThrough(RateLimit::class, Policy::class);
    }


}

