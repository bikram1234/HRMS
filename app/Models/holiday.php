<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class holiday extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'holidaytype_id',
        'optradioholidayfrom',
        'start_date',
        'optradioholidaylto',
        'end_date',
        'number_of_days',
        'description',
    ];

    public function holidayType()
    {
        return $this->belongsTo(HolidayType::class, 'holidaytype_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'region_holidays', 'holiday_id', 'region_id')->withTimestamps();;
    }

}
