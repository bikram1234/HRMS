<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Add this line

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // Add HasRoles here

    protected $fillable = [
        'name',
        'is_admin',
        'email',
        'employee_id',
        'password',
        'department_id',
        'section_id',
        'designation_id',
        'grade_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function assignUserRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->assignRole($role);
        }
    }
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function rateLimits()
    {
        return $this->hasMany(RateLimit::class);
    }

    public function dsaAdvances()
    {
        return $this->hasMany(DsaAdvance::class, 'user_id');
    }
}
