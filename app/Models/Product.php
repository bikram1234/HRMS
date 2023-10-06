<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'designation',
        'department',
        'basic_pay',
        'transfer_claim_type',
        'current_location',
        'new_location',
        'claim_amount',
        'distance_km',
    ];
}
