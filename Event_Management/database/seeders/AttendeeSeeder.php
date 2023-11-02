<?php

namespace Database\Seeders;

use App\Models\Attendee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;

class AttendeeSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::all();
        $events = Event::all();
        foreach ($users as $user) {
            $eventToAttend = $events->random(rand(1, 3));
            foreach ($eventToAttend as $event) {
                Attendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }
    }
}
