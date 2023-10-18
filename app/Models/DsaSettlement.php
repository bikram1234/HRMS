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
        'level1',
        'level2',
        'level3',
        'status',
        'remark',
        'creation_date',
        'expensetype_id'

    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->creation_date = now(); // Set the 'creation_date' attribute to the current date

            // Fetch the expense type and set the 'expensetype_id' attribute
            $expenseType = ExpenseType::where('name', 'DSA Settlement')->first();
            if ($expenseType) {
                $model->expensetype_id = $expenseType->id;
            } else {
                // Handle the case where the expense type does not exist
                echo "Expense type not found.";
            }
        });
    }

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

