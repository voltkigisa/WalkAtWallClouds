<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TicketType;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketType::insert([
            [
                'event_id' => 1,
                'name' => 'VIP',
                'price' => 2000000,
                'quota' => 100,
            ],
            [
                'event_id' => 1,
                'name' => 'Festival',
                'price' => 750000,
                'quota' => 1000,
            ]
        ]);

    }
}
