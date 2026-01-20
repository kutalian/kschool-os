<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class HostelRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hostel_id',
        'room_number',
        'room_type',
        'capacity',
        'cost_per_term',
        'description',
        'is_active',
    ];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function allocations()
    {
        return $this->hasMany(HostelAllocation::class, 'room_id');
    }
}
