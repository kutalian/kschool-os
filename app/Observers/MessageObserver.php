<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        Notification::create([
            'user_id' => $message->receiver_id,
            'title' => 'New Message',
            'message' => 'You have received a new message from ' . $message->sender->name,
            'type' => 'Info',
            'category' => 'Message',
            'link_url' => $this->getLinkUrl($message),
            'is_read' => false,
        ]);
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        if ($message->isDirty('is_read') && $message->is_read) {
            Notification::where('user_id', $message->receiver_id)
                ->where('link_url', $this->getLinkUrl($message))
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        Notification::where('user_id', $message->receiver_id)
            ->where('link_url', $this->getLinkUrl($message))
            ->delete();
    }

    /**
     * Determine the correct link URL based on the receiver's role.
     */
    private function getLinkUrl(Message $message): string
    {
        $receiver = User::find($message->receiver_id);

        if ($receiver->role === 'admin') {
            return route('messages.show', $message->id);
        }

        if ($receiver->role === 'staff') {
            return route('staff.messages.show', $message->id);
        }

        // Default or other roles
        return '#';
    }
}
