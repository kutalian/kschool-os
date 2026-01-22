<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'date',
        'description',
        'call_type',
        'duration',
        'follow_up_date',
        'created_by',
    ];

    protected $casts = [
        'date' => 'datetime',
        'follow_up_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
