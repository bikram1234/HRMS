<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave_plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'leave_id',
        'attachment_required',
        'gender',
        'leave_year',
        'credit_frequency',
        'credit',
        'include_public_holidays',
        'include_weekends',
        'can_be_clubbed_with_el',
        'can_be_clubbed_with_cl',
        'can_be_half_day',
        'probation_period',
        'regular_period',
        'contract_period',
        'notice_period',
    ];
}
