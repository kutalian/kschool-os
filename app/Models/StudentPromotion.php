<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPromotion extends Model
{
    use HasFactory;

    protected $table = 'student_promotions';

    public $timestamps = false; // Based on schema, generally only created_at is needed or handled manually as 'allocated_at' style

    protected $fillable = [
        'student_id',
        'from_class_id',
        'to_class_id',
        'from_session',
        'to_session',
        'promotion_status',
        'promotion_date',
        'remarks',
        'promoted_by',
        'created_at'
    ];

    protected $casts = [
        'promotion_date' => 'date',
        'created_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function fromClass()
    {
        return $this->belongsTo(ClassRoom::class, 'from_class_id');
    }

    public function toClass()
    {
        return $this->belongsTo(ClassRoom::class, 'to_class_id');
    }

    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoted_by'); // Assuming User model for staff/admin
    }
}
