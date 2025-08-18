<?php

namespace App\Types;

enum SkillType: string
{
    case Physical = 'physical';
    case Magic = 'magic';

    public function label(): string
    {
        return match ($this) {
            self::Physical => '物理',
            self::Magic => '魔法',
        };
    }
}
