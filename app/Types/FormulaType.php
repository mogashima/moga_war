<?php

namespace App\Types;

enum FormulaType: int
{
    case Normal = 1;
    case Power = 2;
    case Heal = 3;

    public function label(): string
    {
        return match ($this) {
            self::Normal => '通常',
            self::Power => 'パワー異存',
            self::Heal => 'パワー回復',
        };
    }
}
