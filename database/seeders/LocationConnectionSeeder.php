<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocationConnection;

class LocationConnectionSeeder extends Seeder
{
    public function run(): void
    {
        // 各拠点間の接続を定義（片方向で記述）
        $connections = [
            ['from_location_code' => 'L01', 'to_location_code' => 'L04'],
            ['from_location_code' => 'L01', 'to_location_code' => 'L05'],
            ['from_location_code' => 'L01', 'to_location_code' => 'L07'],
            ['from_location_code' => 'L01', 'to_location_code' => 'L08'],
            ['from_location_code' => 'L02', 'to_location_code' => 'L07'],
            ['from_location_code' => 'L02', 'to_location_code' => 'L08'],
            ['from_location_code' => 'L02', 'to_location_code' => 'L09'],
            ['from_location_code' => 'L03', 'to_location_code' => 'L05'],
            ['from_location_code' => 'L03', 'to_location_code' => 'L07'],
            ['from_location_code' => 'L04', 'to_location_code' => 'L08'],
            ['from_location_code' => 'L05', 'to_location_code' => 'L06'],
            ['from_location_code' => 'L07', 'to_location_code' => 'L09'],
            ['from_location_code' => 'L07', 'to_location_code' => 'L08'],
            ['from_location_code' => 'L09', 'to_location_code' => 'L10'],
        ];

        foreach ($connections as $conn) {
            // 元の方向で作成
            LocationConnection::create($conn);
            // 逆方向も作成して双方向化
            LocationConnection::create([
                'from_location_code' => $conn['to_location_code'],
                'to_location_code' => $conn['from_location_code'],
            ]);
        }
    }
}
