<?php

namespace App\Observers;

use App\Models\Notice;
use App\Models\Notification;
use App\Models\User;

class NoticeObserver
{
    /**
     * Handle the Notice "created" event.
     */
    public function created(Notice $notice): void
    {
        // Get target users based on audience
        $users = $this->getTargetUsers($notice->audience);

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'New Announcement: ' . $notice->title,
                'message' => $notice->message,
                'type' => 'Info',
                'category' => 'Announcement',
                'link_url' => $this->getLinkUrl($user),
                'is_read' => false,
            ]);
        }
    }

    /**
     * Get users based on audience type.
     */
    private function getTargetUsers(string $audience)
    {
        $query = User::query();

        if ($audience !== 'all') {
            $query->where('role', $audience);
        }

        return $query->get(['id', 'role']);
    }

    /**
     * Determine the correct link URL based on user role.
     */
    private function getLinkUrl(User $user): string
    {
        // Notices usually appear on the dashboard or a general notices page
        return route('dashboard');
    }
}
