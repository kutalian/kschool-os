<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'content',
        'is_anonymous',
        'is_pinned',
        'is_locked',
        'view_count',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class, 'post_id');
    }

    public function poll()
    {
        return $this->hasOne(ForumPoll::class);
    }
}
