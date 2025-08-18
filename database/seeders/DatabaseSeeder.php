<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FactionSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(LocationConnectionSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(PersonSkillCodeSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
