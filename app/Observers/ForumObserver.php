<?php

namespace App\Observers;

use App\Models\ForumComment;
use App\Models\Notification;

class ForumObserver
{
    /**
     * Handle the ForumComment "created" event.
     */
    public function created(ForumComment $comment): void
    {
        $post = $comment->post;

        // Don't notify the author if they are the one commenting
        if ($post->user_id === $comment->user_id) {
            return;
        }

        Notification::create([
            'user_id' => $post->user_id,
            'title' => 'New Comment on Your Post',
            'message' => $comment->user->name . ' commented on: ' . $post->title,
            'type' => 'Info',
            'category' => 'Forum',
            'link_url' => route('forum.show', $post->id),
            'is_read' => false,
        ]);
    }
}
