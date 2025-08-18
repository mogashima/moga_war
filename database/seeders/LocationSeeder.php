<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'ミラトス', 'pos_x' => 2, 'pos_y' => 2, 'code' => 'L01', 'faction_code' => 'F01'],
            ['name' => 'カレノア', 'pos_x' => 4, 'pos_y' => 6, 'code' => 'L02', 'faction_code' => 'F02'],
            ['name' => 'ルドナック', 'pos_x' => 6, 'pos_y' => 3, 'code' => 'L03', 'faction_code' => 'F03'],
            ['name' => 'オルディア', 'pos_x' => 1, 'pos_y' => 3, 'code' => 'L04', 'faction_code' => 'F01'],
            ['name' => 'ネイラム', 'pos_x' => 4, 'pos_y' => 2, 'code' => 'L05', 'faction_code' => 'F04'],
            ['name' => 'サルヴァリオ', 'pos_x' => 5, 'pos_y' => 1, 'code' => 'L06', 'faction_code' => 'F04'],
            ['name' => 'トリシェル', 'pos_x' => 4, 'pos_y' => 4, 'code' => 'L07', 'faction_code' => 'F03'],
            ['name' => 'ヴァレニア', 'pos_x' => 2, 'pos_y' => 5, 'code' => 'L08', 'faction_code' => 'F01'],
            ['name' => 'グラステア', 'pos_x' => 6, 'pos_y' => 6, 'code' => 'L09', 'faction_code' => 'F02'],
            ['name' => 'ゼフィーナ', 'pos_x' => 9, 'pos_y' => 6, 'code' => 'L10', 'faction_code' => 'F02'],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }
    }
}