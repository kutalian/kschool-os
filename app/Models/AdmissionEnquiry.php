<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'class_applying_for',
        'no_of_children',
        'description',
        'status',
        'assigned_to',
        'date',
        'next_follow_up',
        'source',
    ];

    protected $casts = [
        'date' => 'date',
        'next_follow_up' => 'date',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
