<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicPay extends Model
{
    use HasFactory;

    protected $fillable = ['grade_id', 'amount'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}

