<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::create([
            'title' => 'Walk At Wall Clouds',
            'description' => 'International Music Concert',
            'location' => 'Jakarta',
            'event_date' => '2025-08-20',
            'start_time' => '18:00',
            'end_time' => '23:00',
            'status' => 'published',
        ]);

    }
}
