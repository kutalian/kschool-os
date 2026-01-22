<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'vaccine_name',
        'dose_number',
        'vaccination_date',
        'next_dose_date',
        'administered_by',
        'hospital_name',
        'batch_number',
        'certificate_file',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'next_dose_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
