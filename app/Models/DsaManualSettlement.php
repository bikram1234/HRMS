<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsaManualSettlement extends Model
{
    protected $fillable = [
        'user_id',
        'from_date',
        'from_location',
        'to_date',
        'to_location',
        'total_days',
        'da',
        'ta',
        'total_amount',
        'remark',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dsaSettlement()
    {
        return $this->belongsTo(DsaSettlement::class, 'dsa_settlement_id');
    }
    
    public function dsaAdvance()
    {
        return $this->belongsTo(DsaAdvance::class, 'advance_no', 'advance_no');
    }

    

}
