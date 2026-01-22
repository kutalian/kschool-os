<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLike extends Model
{
    use HasFactory;

    public $timestamps = false; // Only created_at in schema

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function post()
    {
        return $this->belongsTo(ForumPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
