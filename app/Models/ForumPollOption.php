<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPollOption extends Model
{
    use HasFactory;

    protected $fillable = ['forum_poll_id', 'option_text', 'vote_count'];

    public function poll()
    {
        return $this->belongsTo(ForumPoll::class);
    }
}
