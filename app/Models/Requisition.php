<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Requisition extends Model
{
    protected $fillable = [
        'requisition_type',
        'requisition_date',
        'need_by_date',
        'employee_name',
        'item_category',
        'item_no',
        'description',
        'specification',
        'remarks',
        'uom',
        'required_qty',
        'file_path',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate a unique requisition number before creating a new record
        static::creating(function ($requisition) {
            $requisition->requisition_no = 'REQ' . str_pad($requisition->id, 5, '0', STR_PAD_LEFT);
        });
    }
}
