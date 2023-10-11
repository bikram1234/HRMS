<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_name', // Update the validation rules
        'user_id',
        'location',
        'date',
        'vehicle_no',
        'vehicle_type' ,
        'initial_km',
        'final_km' ,
        'quantity' ,
        'mileage',
        'rate',
        'amount',
        'level1',
        'level2',
        'level3',
        'status',
        'remark',
    ];
}
