<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;

    protected $table = 'academic_sessions';

    protected $fillable = [
        'session_name',
        'start_date',
        'end_date',
        'is_current',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function terms()
    {
        return $this->hasMany(Term::class, 'session_id');
    }
}
