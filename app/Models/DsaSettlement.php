<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DsaSettlement extends Model
{
    protected $fillable = [
        'user_id',
        'advance_no', 
        'advance_amount',
        'total_amount_adjusted',
        'net_payable_amount',
        'balance_amount',
        'upload_file',
        'status',
        'remark'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dsaAdvance()
    {
        return $this->belongsTo(DsaAdvance::class);
    }
   
    public function manualSettlements()
    {
        return $this->hasMany(DsaManualSettlement::class, 'dsa_settlement_id');
    }

}

