<?php
namespace App\Types;

use App\Helpers\RankAdjuster;
use App\Helpers\StatRandomizer;

enum JobType: string
{
    case None = 'ノージョブ';
    case Fighter = 'ファイター';
    case Wizard = 'ウィザード';
    case Ninja = 'ニンジャ';
    case Priest = 'プリースト';
    case Monk = 'モンク';
    case Dragoon = 'ドラグーン';
    case Summoner = 'サモナー';

    public function baseStats(): array
    {
        return match ($this) {
            self::None => ['hp' => 50, 'mp' => 5, 'strength' => 5, 'intelligence' => 5, 'defense' => 5, 'resist' => 5, 'agility' => 5],
            self::Fighter => ['hp' => 120, 'mp' => 10, 'strength' => 50, 'intelligence' => 10, 'defense' => 40, 'resist' => 20, 'agility' => 20],
            self::Wizard => ['hp' => 70, 'mp' => 60, 'strength' => 10, 'intelligence' => 50, 'defense' => 10, 'resist' => 40, 'agility' => 30],
            self::Ninja => ['hp' => 80, 'mp' => 20, 'strength' => 30, 'intelligence' => 20, 'defense' => 20, 'resist' => 20, 'agility' => 60],
            self::Priest => ['hp' => 90, 'mp' => 50, 'strength' => 20, 'intelligence' => 45, 'defense' => 20, 'resist' => 50, 'agility' => 25],
            self::Monk => ['hp' => 100, 'mp' => 20, 'strength' => 45, 'intelligence' => 15, 'defense' => 30, 'resist' => 30, 'agility' => 40],
            self::Dragoon => ['hp' => 110, 'mp' => 15, 'strength' => 40, 'intelligence' => 25, 'defense' => 35, 'resist' => 25, 'agility' => 35],
            self::Summoner => ['hp' => 75, 'mp' => 65, 'strength' => 15, 'intelligence' => 55, 'defense' => 15, 'resist' => 35, 'agility' => 20],
        };
    }

    /**
     * キャラクター作成時のステータス生成
     */
    public function generateStats(int $rank = 1, float $randomRange = 0.1): array
    {
        $base = $this->baseStats();

        // ランク補正
        $ranked = RankAdjuster::applyRank($base, $rank);

        // ランダム補正
        $randomized = StatRandomizer::applyRandom($ranked, $randomRange);

        return $randomized;
    }

    /**
     * レベルアップ時のステータス成長
     * - 現在のステータスに対して固定比率 or 小さなランダム変動で上昇
     */
    public function levelUpStats(array $currentStats, float $growthRate = 0.05, float $randomRange = 0.02): array
    {
        $newStats = [];

        foreach ($currentStats as $key => $value) {
            // 固定成長分
            $increase = (int) round($value * $growthRate);

            // 小さなランダム補正
            $randFactor = 1 + (mt_rand() / mt_getrandmax() * 2 - 1) * $randomRange;
            $increase = (int) round($increase * $randFactor);

            $newStats[$key] = max(1, $value + $increase); // 1未満にならないように
        }

        return $newStats;
    }
}
