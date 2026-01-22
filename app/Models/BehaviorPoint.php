<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BehaviorPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'points',
        'reason',
        'type',
        'category',
        'awarded_by',
        'awarded_date',
    ];

    protected $casts = [
        'awarded_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function awarder()
    {
        return $this->belongsTo(User::class, 'awarded_by');
    }
}
