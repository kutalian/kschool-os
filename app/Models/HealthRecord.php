<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'record_date',
        'record_type',
        'symptoms',
        'diagnosis',
        'treatment',
        'medication_prescribed',
        'doctor_name',
        'hospital_name',
        'height',
        'weight',
        'blood_pressure',
        'temperature',
        'next_checkup',
        'attachment',
        'created_by',
    ];

    protected $casts = [
        'record_date' => 'date',
        'next_checkup' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
