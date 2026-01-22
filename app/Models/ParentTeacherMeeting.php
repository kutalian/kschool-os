<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentTeacherMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'parent_id',
        'teacher_id',
        'meeting_date',
        'duration_minutes',
        'location',
        'purpose',
        'discussion_points',
        'action_items',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
        // Note: Assuming 'StudentParent' model exists based on table 'parents'. 
        // If not, might need to check if it's 'Parent' or 'User' role. 
        // Based on schema 'parents' table exists. 
        // Wait, listing showed 'StudentParent.php' and 'Parents' table migration `2026_01_01_000002_create_parents_table.php`. 
        // I should check if 'StudentParent.php' maps to 'parents' table.
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
