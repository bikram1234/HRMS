<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_name', // Update the validation rules
        'user_id',
        'location',
        'date',
        'vehicle_no',
        'vehicle_type' ,
        'initial_km',
        'final_km' ,
        'quantity' ,
        'mileage',
        'rate',
        'amount',
        'level1',
        'level2',
        'level3',
        'status',
        'remark',
        'expense_type_id',
        'attachment',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Fetch the expense type and set the 'expensetype_id' attribute
            $expenseType = ExpenseType::where('name', 'Expense Fuel')->first();
            if ($expenseType) {
                $model->expense_type_id = $expenseType->id;
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
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class,'expense_type_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_type_id');
    }
}
