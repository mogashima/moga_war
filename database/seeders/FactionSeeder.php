<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faction;

class FactionSeeder extends Seeder
{
    public function run(): void
    {
        Faction::create(['name' => '松陰', 'code' => 'F01', 'color' => '#ff4f4fff']);
        Faction::create(['name' => '桜花', 'code' => 'F02', 'color' => '#2ff72fff']);
        Faction::create(['name' => '藍屋', 'code' => 'F03', 'color' => '#3a3affff']);
        Faction::create(['name' => '風林', 'code' => 'F04', 'color' => '#c9c9c9ff']);

    }
}