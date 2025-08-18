<?php

namespace App\Types;

enum TargetType: string
{
    case Enemy = 'enemy';
    case Ally = 'ally';
    case AllEnemies = 'all_enemies';
    case AllAllies = 'all_allies';
    case Self = 'self';

    public function label(): string
    {
        return match ($this) {
            self::Enemy => '敵単体',
            self::Ally => '味方単体',
            self::AllEnemies => '敵全体',
            self::AllAllies => '味方全体',
            self::Self => '自分自身',
        };
    }
}
