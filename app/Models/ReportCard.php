<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'exam_id',
        'academic_year',
        'term',
        'total_marks',
        'percentage',
        'grade',
        'rank',
        'attendance_percentage',
        'teacher_remarks',
        'principal_remarks',
        'status',
        'generated_by',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
