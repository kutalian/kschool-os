<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone',
        'graduation_year',
        'graduation_class',
        'current_occupation',
        'company_name',
        'achievements',
        'linkedin_url',
        'address',
        'willing_to_mentor',
        'is_active',
    ];

    protected $casts = [
        'willing_to_mentor' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function donations()
    {
        return $this->hasMany(AlumniDonation::class, 'alumni_id');
    }
}
