<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'user_id',
        'designation',
        'department',
        'basic_pay',
        'transfer_claim_type',
        'current_location',
        'new_location',
        'claim_amount',
        'distance_km',
        'level1',
        'level2',
        'level3',
        'status',
        'expense_type_id',
        'attachment',
        'remark',

    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class,'expense_type_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Fetch the expense type and set the 'expensetype_id' attribute
            $expenseType = ExpenseType::where('name', 'Transfer Claim')->first();
            if ($expenseType) {
                $model->expense_type_id = $expenseType->id;
            } else {
                // Handle the case where the expense type does not exist
                echo "Expense type not found.";
            }
        });
    }
}
