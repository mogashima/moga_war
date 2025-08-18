<?php
namespace App\Helpers;

class RankAdjuster
{
    public static function applyRank(array $baseStats, int $rank): array
    {
        // 1ランクごとに5%上昇（ランク1は補正なし）
        $multiplier = 1 + 0.05 * max($rank - 1, 0);
        foreach ($baseStats as $key => $value) {
            $baseStats[$key] = (int) round($value * $multiplier);
        }
        return $baseStats;
    }
}
