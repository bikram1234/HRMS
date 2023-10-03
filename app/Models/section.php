<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'status'
    ];

    public function departmentName()
    {
        return $this->belongsTo(Department::class, 'department');
    }
}
