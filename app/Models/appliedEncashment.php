<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appliedEncashment extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'number_of_days',
            'amount',
            'remark',
            'level1',
            'level2',
            'level3',
            'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
