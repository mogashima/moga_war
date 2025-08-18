<?php

namespace Database\Seeders;

use App\Types\FormulaType;
use App\Types\SkillType;
use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Types\TargetType;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Skill::insert([
            [
                'name' => 'たたかう',
                'code' => 'S001',
                'type' => SkillType::Physical,
                'target' => TargetType::Enemy,
                'formula_type' => FormulaType::Normal,
                'power' => 0,
                'cost' => 0,
                'description' => '通常の物理攻撃',
            ],
            [
                'name' => 'ファイア',
                'code' => 'S002',
                'type' => SkillType::Magic,
                'target' => TargetType::Enemy,
                'formula_type' => FormulaType::Normal,
                'power' => 0,
                'cost' => 10,
                'description' => '炎属性の魔法攻撃',
            ],
            [
                'name' => 'ヒール',
                'code' => 'S003',
                'type' => SkillType::Magic,
                'target' => TargetType::Ally,
                'formula_type' => FormulaType::Heal,
                'power' => 50,
                'cost' => 8,
                'description' => '味方1人のHPを回復する',
            ],
        ]);
    }
}