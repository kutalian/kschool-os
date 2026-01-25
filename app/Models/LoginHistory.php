<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $table = 'login_history';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'login_time',
        'logout_time',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'status',
        'failure_reason',
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
