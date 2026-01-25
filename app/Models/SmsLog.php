<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $table = 'sms_logs';

    protected $fillable = [
        'recipient_phone',
        'recipient_name',
        'message',
        'sms_type',
        'status',
        'gateway_response',
        'sent_at',
        'cost',
        'created_by',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'cost' => 'decimal:4',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
