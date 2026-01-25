<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationQueue extends Model
{
    use HasFactory;

    protected $table = 'notification_queue';

    protected $fillable = [
        'recipient_type',
        'recipient_id',
        'recipient_email',
        'recipient_phone',
        'subject',
        'message',
        'notification_type',
        'status',
        'sent_at',
        'error_message',
        'retry_count',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
