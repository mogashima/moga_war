<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PersonSkillController extends Controller
{
    /**
     * スキル追加
     */
    public function store(Request $request, Person $person): JsonResponse
    {
        $request->validate([
            'skill_id' => 'required|exists:skills,id',
        ]);

        $skill = Skill::findOrFail($request->skill_id);

        // 重複チェック
        if ($person->skills()->where('skills.code', $skill->code)->exists()) {
            return $this->jsonResponse(['message' => 'すでにスキルを持っています'], 409);
        }

        $person->skills()->attach($skill->code);

        return $this->jsonResponse(['message' => 'スキルを追加しました']);
    }

    /**
     * スキル削除
     */
    public function destroy(Person $person, Skill $skill): JsonResponse
    {
        $person->skills()->detach($skill->code);

        return $this->jsonResponse(['message' => 'スキルを削除しました']);
    }
}
