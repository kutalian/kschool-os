<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff'; // Explicitly set table name since plural of staff is staff or staffs

    protected $fillable = [
        'user_id',
        'employee_id',
        'name',
        'email',
        'phone',
        'role_type',
        'dob',
        'gender',
        'profile_pic',
        'current_address',
        'permanent_address',
        'qualification',
        'experience_years',
        'joining_date',
        'basic_salary',
        'is_active',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class, 'class_teacher_id');
    }

    public function getFirstNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return $parts[0] ?? '';
    }

    public function getLastNameAttribute()
    {
        $parts = explode(' ', $this->name);
        return isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : '';
    }
}
