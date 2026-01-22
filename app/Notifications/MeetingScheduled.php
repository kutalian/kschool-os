<?php

namespace App\Notifications;

use App\Models\ParentTeacherMeeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingScheduled extends Notification
{
    use Queueable;

    public $meeting;

    /**
     * Create a new notification instance.
     */
    public function __construct(ParentTeacherMeeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // For now, we will store it in the database.
        // If mail is configured, we can add 'mail'.
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('PTM Scheduled')
            ->line('A Parent-Teacher Meeting has been scheduled.')
            ->line('Date: ' . $this->meeting->meeting_date->format('M d, Y h:i A'))
            ->line('Student: ' . $this->meeting->student->name)
            ->line('Purpose: ' . $this->meeting->purpose)
            ->action('View Details', url('/parent/dashboard')) // Assuming parent dashboard exists
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'meeting_id' => $this->meeting->id,
            'title' => 'New PTM Scheduled',
            'message' => 'A meeting regarding ' . $this->meeting->student->name . ' is scheduled on ' . $this->meeting->meeting_date->format('d M h:i A'),
            'type' => 'PTM',
            'action_url' => route('parent-teacher-meetings.index'), // Or parent specific route
        ];
    }
}
