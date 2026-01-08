<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_no',
        'name',
        'email',
        'phone',
        'class_id',
        'parent_id',
        'admission_date',
        'roll_no',
        'dob',
        'gender',
        'profile_pic',
        'blood_group',
        'nationality',
        'religion',
        'category',
        'current_address',
        'permanent_address',
        'card_id',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
