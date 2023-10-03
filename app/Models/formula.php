<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class formula extends Model
{
    use HasFactory;

    protected $fillable = [
        'condition',
        'field',
        'operator',
        'value',
        'employee_id',
        'condition_id',
    ];

    public function employee() {
        return $this->belongsTo(user::class, 'employee_id');
    }
}
