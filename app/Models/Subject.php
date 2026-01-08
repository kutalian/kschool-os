<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'credit_hours',
        'is_active',
    ];

    public function classes()
    {
        return $this->belongsToMany(ClassRoom::class, 'class_subjects', 'subject_id', 'class_id');
    }
}
