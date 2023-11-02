<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class EventSeeder extends Seeder
{

    public function run(): void
    {
        $users = User::all();
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            Event::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
