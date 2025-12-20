<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = Artist::insert([
            ['name'=>'Artist A','country'=>'USA','genre'=>'Pop'],
            ['name'=>'Artist B','country'=>'UK','genre'=>'Rock'],
        ]);

    }
}
