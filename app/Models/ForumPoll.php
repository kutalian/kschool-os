<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPoll extends Model
{
    use HasFactory;

    protected $fillable = ['forum_post_id', 'question', 'is_active'];

    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function options()
    {
        return $this->hasMany(ForumPollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(ForumPollVote::class);
    }

    public function hasVoted($userId)
    {
        return $this->votes()->where('user_id', $userId)->exists();
    }
}
