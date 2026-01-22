<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reference_no',
        'sender_name',
        'receiver_name',
        'address',
        'date',
        'note',
        'attachment',
        'is_confidential',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'is_confidential' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
