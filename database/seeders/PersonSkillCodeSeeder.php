<?php

namespace Database\Seeders;

use App\Types\JobType;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\PersonSkillCode;

class PersonSkillCodeSeeder extends Seeder
{
    public function run(): void
    {
        $people = Person::all();

        $data = [];
        foreach ($people as $person) {
            // 全員に共通の「たたかう」スキル
            $data[] = [
                'person_code' => $person->code,
                'skill_code' => 'S001', // たたかう
            ];

            // ジョブごとのスキルを追加
            switch ($person->job) {
                case JobType::Fighter->value:
                    break;
                case JobType::Wizard->value:
                    $data[] = [
                        'person_code' => $person->code,
                        'skill_code' => 'S002',
                    ];
                    break;
                case JobType::Ninja->value:
                    break;
                case JobType::Priest->value:
                    $data[] = [
                        'person_code' => $person->code,
                        'skill_code' => 'S003',
                    ];
                    break;
                case JobType::Monk->value:
                    break;
                case JobType::Dragoon->value:
                    break;
                case JobType::Summoner->value:
                    $data[] = [
                        'person_code' => $person->code,
                        'skill_code' => 'S003',
                    ];
                    break;

                default:
                    // 特になければ何もしない or 共通スキルを追加
                    break;
            }
        }

        PersonSkillCode::insert($data);
    }
}
