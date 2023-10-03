<?php

// app/Models/DsaAdvance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DsaAdvance extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'user_id','advance_type_id', 'advance_no', 'date', 'mode_of_travel', 'from_location', 'to_location',
        'from_date', 'to_date', 'amount', 'purpose', 'upload_file','remark'
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function dsaSettlement()
    {
        return $this->hasMany(DsaSettlement::class);
    }

    public function manualSettlements()
    {
        return $this->hasMany(DsaManualSettlement::class, 'advance_no', 'advance_no');
    }
}

