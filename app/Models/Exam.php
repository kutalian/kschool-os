<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'exam_type',
        'class_id',
        'start_date',
        'end_date',
        'academic_year',
        'term',
        'is_published',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function class_room()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
