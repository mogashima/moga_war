<?php
namespace App\Helpers;

class StatRandomizer
{
    public static function applyRandom(array $baseStats, float $range = 0.1): array
    {
        foreach ($baseStats as $key => $value) {
            // -$range ~ +$range の割合でランダム変動
            $randFactor = 1 + (mt_rand() / mt_getrandmax() * 2 - 1) * $range;
            $baseStats[$key] = max(1, (int) round($value * $randFactor));  // 1未満にはしない
        }
        return $baseStats;
    }
}
