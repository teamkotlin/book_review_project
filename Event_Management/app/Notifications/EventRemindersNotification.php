<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class EventRemindersNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct(public Event $event)
    {

    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Reminder: You have an upcoming event!!')
            ->action('View', route('events.show', $this->event->id))
            ->line('The event {{$this->event->name}} starts at {{$this->event->start_time}}');
    }


    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_name' => $this->event->name,
            'event_start_time' => $this->event->start_time
        ];
    }
}
