<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Types\JobType;
use Carbon\Carbon;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $characters = [
            ['name' => 'あきら', 'job' => JobType::Ninja, 'location_code' => 'L05', 'rank' => 5, 'code' => 'P001'],
            ['name' => 'あやな', 'job' => JobType::Priest, 'location_code' => 'L07', 'rank' => 2, 'code' => 'P002'],
            ['name' => 'うみか', 'job' => JobType::Wizard, 'location_code' => 'L09', 'rank' => 4, 'code' => 'P003'],
            ['name' => 'えみ', 'job' => JobType::Wizard, 'location_code' => 'L09', 'rank' => 2, 'code' => 'P004'],
            ['name' => 'えりな', 'job' => JobType::Priest, 'location_code' => 'L02', 'rank' => 2, 'code' => 'P005'],
            ['name' => 'かりん', 'job' => JobType::Fighter, 'location_code' => 'L09', 'rank' => 1, 'code' => 'P006'],
            ['name' => 'かな', 'job' => JobType::Dragoon, 'location_code' => 'L02', 'rank' => 2, 'code' => 'P007'],
            ['name' => 'かのん', 'job' => JobType::Wizard, 'location_code' => 'L07', 'rank' => 1, 'code' => 'P008'],
            ['name' => 'ことね', 'job' => JobType::Fighter, 'location_code' => 'L05', 'rank' => 2, 'code' => 'P009'],
            ['name' => 'さくら', 'job' => JobType::Fighter, 'location_code' => 'L07', 'rank' => 4, 'code' => 'P010'],
            ['name' => 'さつき', 'job' => JobType::Fighter, 'location_code' => 'L01', 'rank' => 4, 'code' => 'P011'],
            ['name' => 'しおり', 'job' => JobType::Priest, 'location_code' => 'L06', 'rank' => 2, 'code' => 'P012'],
            ['name' => 'すず', 'job' => JobType::Wizard, 'location_code' => 'L10', 'rank' => 1, 'code' => 'P013'],
            ['name' => 'ちさと', 'job' => JobType::Fighter, 'location_code' => 'L08', 'rank' => 1, 'code' => 'P014'],
            ['name' => 'なつみ', 'job' => JobType::Fighter, 'location_code' => 'L02', 'rank' => 3, 'code' => 'P015'],
            ['name' => 'なな', 'job' => JobType::Summoner, 'location_code' => 'L05', 'rank' => 4, 'code' => 'P016'],
            ['name' => 'はるな', 'job' => JobType::Dragoon, 'location_code' => 'L03', 'rank' => 3, 'code' => 'P017'],
            ['name' => 'ひさえ', 'job' => JobType::Wizard, 'location_code' => 'L02', 'rank' => 2, 'code' => 'P018'],
            ['name' => 'まな', 'job' => JobType::Summoner, 'location_code' => 'L03', 'rank' => 3, 'code' => 'P019'],
            ['name' => 'みおう', 'job' => JobType::Dragoon, 'location_code' => 'L05', 'rank' => 3, 'code' => 'P020'],
            ['name' => 'みほ', 'job' => JobType::Priest, 'location_code' => 'L01', 'rank' => 3, 'code' => 'P021'],
            ['name' => 'みなみ', 'job' => JobType::Priest, 'location_code' => 'L01', 'rank' => 2, 'code' => 'P022'],
            ['name' => 'みゆう', 'job' => JobType::Wizard, 'location_code' => 'L07', 'rank' => 2, 'code' => 'P023'],
            ['name' => 'めぐみ', 'job' => JobType::Wizard, 'location_code' => 'L04', 'rank' => 3, 'code' => 'P024'],
            ['name' => 'ももか', 'job' => JobType::Priest, 'location_code' => 'L05', 'rank' => 1, 'code' => 'P025'],
            ['name' => 'やよい', 'job' => JobType::Fighter, 'location_code' => 'L01', 'rank' => 3, 'code' => 'P026'],
            ['name' => 'ゆうこ', 'job' => JobType::Priest, 'location_code' => 'L04', 'rank' => 3, 'code' => 'P027'],
            ['name' => 'ゆりな', 'job' => JobType::Wizard, 'location_code' => 'L08', 'rank' => 1, 'code' => 'P028'],
            ['name' => 'れんげ', 'job' => JobType::Monk, 'location_code' => 'L06', 'rank' => 4, 'code' => 'P029'],
        ];
        //kaho
        $data = [];
        //$index = 1;

        foreach ($characters as $char) {
            $rank = $char['rank'] ?? 1;
            $stats = $char['job']->generateStats($rank, 0.1);

            $data[] = [
                'name' => $char['name'],
                //'code' => sprintf('P%03d', $index++),
                'code' => $char['code'],
                'lv' => 1,
                'hp' => $stats['hp'],
                'mp' => $stats['mp'],
                'strength' => $stats['strength'],
                'intelligence' => $stats['intelligence'],
                'defense' => $stats['defense'],
                'resist' => $stats['resist'],
                'agility' => $stats['agility'],
                'job' => $char['job']->value,
                'location_code' => $char['location_code'],
                'rank' => $char['rank'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('people')->insert($data);
    }
}
