<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $table = 'email_logs';

    protected $fillable = [
        'recipient_email',
        'recipient_name',
        'subject',
        'message',
        'email_type',
        'status',
        'error_message',
        'sent_at',
        'opened_at',
        'created_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
