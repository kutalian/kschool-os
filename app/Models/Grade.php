<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grading_system';

    public $timestamps = false;

    protected $fillable = [
        'grade',
        'min_marks',
        'max_marks',
        'grade_point',
        'description',
        'color_code',
        'is_active',
    ];
}
