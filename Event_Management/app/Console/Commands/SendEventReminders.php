<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;


class SendEventReminders extends Command
{

    protected $signature = 'app:send-event-reminders';


    protected $description = 'Command description';


    public function handle()
    {
        $events = Event::with('attendees.user')->whereBetween('start_time', [now(), now()->addDay()])->get();
        $eventCount = $events->count();

        $eventLabel = Str::plural('event', $eventCount);
        $events->each(fn($event) => $event->attendees->each(fn($attendee) => $this->info("Found {{$eventCount}} {{$eventLabel}}")));
        //$this->info('Custom Commands to Send Reminders Notifications.{{$eventCount}}');
    }
}
