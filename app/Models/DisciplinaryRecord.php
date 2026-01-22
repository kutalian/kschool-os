<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'incident_date',
        'incident_type',
        'description',
        'action_taken',
        'duration_days',
        'start_date',
        'end_date',
        'reported_by',
        'handled_by',
        'parent_notified',
        'remarks',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'parent_notified' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
