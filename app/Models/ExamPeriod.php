<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPeriod extends Model
{
    use HasFactory;
    protected $fillable = ['exam_id', 'name', 'start_time', 'end_time'];
}
