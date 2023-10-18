<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;
    protected $fillable = [
        'level',
        'value',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'hierarchy_id'
    ];
    public function employeeName()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hierarchy()
    {
        return $this->belongsTo(Hierarchy::class);
    }
}
