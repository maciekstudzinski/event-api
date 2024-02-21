<?php

namespace Database\Seeders;

use App\Models\Atendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $events = Event::all();

        // assigning random events to attendees
        foreach($users as $user) {
            $eventsToAttend = $events->random(rand(1,3));
            foreach ($eventsToAttend as $event) {
                Atendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ]);
            }
        }
    }
}
