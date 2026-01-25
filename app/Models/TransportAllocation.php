<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportAllocation extends Model
{
    use HasFactory;

    protected $table = 'transport_allocations';

    public $timestamps = false; // Based on schema, only 'allocated_at' exists, no updated_at

    protected $fillable = [
        'student_id',
        'route_id',
        'pickup_point',
        'allocated_at',
    ];

    protected $casts = [
        'allocated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'route_id');
    }
}
