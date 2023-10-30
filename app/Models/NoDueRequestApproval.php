<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoDueRequestApproval extends Model
{
    use HasFactory;

    protected $fillable = ['no_due_request_id', 'user_id', 'status'];

    public function noDueRequest()
    {
        return $this->belongsTo(NoDueRequest::class, 'no_due_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
