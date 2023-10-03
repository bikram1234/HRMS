<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_yearend_processing extends Model
{
    use HasFactory;

    protected $fillable = [
        "leave_id",
        "allow_carryover",
        "carryover_limit",
        "payat_yearend",
        "min_balance",
        "max_balance",
        "carryforward_toEL",
        "carryforward_toEL_limit",
    ];
}
