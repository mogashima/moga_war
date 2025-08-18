<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Types\JobType;

class ExperienceController extends Controller
{
    /**
     * 訓練による経験値付与（複数人物対応）
     */
    public function training(Request $request)
    {
        $data = $request->all();

        if (!is_array($data)) {
            return $this->jsonResponse([
                'status' => 'error',
                'message' => '配列で person_id と exp を指定してください'
            ], 400);
        }

        $updatedPersons = [];

        foreach ($data as $item) {
            if (!isset($item['person_id']) || !isset($item['exp'])) {
                continue; // スキップ
            }

            $person = Person::find($item['person_id']);
            if (!$person) {
                continue; // 存在しない人物はスキップ
            }

            // 経験値付与
            $person->exp += (int) $item['exp'];

            // レベルアップ判定
            while ($person->exp >= $this->expToNextLevel($person->lv)) {
                $person->exp -= $this->expToNextLevel($person->lv);
                $person->lv += 1;
                $this->increaseStats($person);
            }

            $person->save();
            $updatedPersons[] = $person;
        }

        return $this->jsonResponse([
            'status' => 'success',
            'persons' => $updatedPersons
        ]);
    }

    private function expToNextLevel(int $lv): int
    {
        return (int) round(100 * pow(1.2, $lv));
    }

    private function increaseStats(Person $person): void
    {
        $currentStats = [
            'hp' => $person->hp,
            'mp' => $person->mp,
            'strength' => $person->strength,
            'intelligence' => $person->intelligence,
            'defense' => $person->defense,
            'resist' => $person->resist,
            'agility' => $person->agility,
        ];

        // 文字列から JobType Enum に変換
        $jobType = JobType::from($person->job); // $person->job は 'Fighter' など文字列

        // ステータス成長を算出
        $newStats = $jobType->generateStats(1, 0); // ランダム補正なし、ランク補正なしで増分を算出するなど調整可能

        // 現在値に上乗せ
        $person->hp += $newStats['hp'];
        $person->mp += $newStats['mp'];
        $person->strength += $newStats['strength'];
        $person->intelligence += $newStats['intelligence'];
        $person->defense += $newStats['defense'];
        $person->resist += $newStats['resist'];
        $person->agility += $newStats['agility'];
    }

}
