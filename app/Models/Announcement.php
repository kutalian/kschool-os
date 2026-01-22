<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'announcement_type',
        'target_audience',
        'target_class_id',
        'priority',
        'start_date',
        'end_date',
        'attachment',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function targetClass()
    {
        return $this->belongsTo(ClassRoom::class, 'target_class_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
