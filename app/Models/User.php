<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\leaveBalance;
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
        'grade_id',
        'region_id',
        'gender',
        'employment_type'
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

    public function region() {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function assignUserRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->assignRole($role);
        }
    }

    public function appliedLeaves()
    {
        return $this->hasMany(AppliedLeave::class);
    }

    public function leaveBalance()
    {
        return $this->hasOne(LeaveBalance::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            LeaveBalance::create(['user_id' => $user->id]);
        });
    }
}
