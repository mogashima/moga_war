<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Person;
use App\Types\JobType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->jsonResponse(Person::with('skills')->get());
    }

    public function store(Request $request): JsonResponse
    {
        // バリデーション
        $request->validate([
            'name'          => 'required|string|max:255',
            'job_code'      => 'required|string',
            'rank'          => 'required|integer|min:1',
            'location_code' => 'required|string|exists:locations,code',
        ]);

        // Jobを取得
        $jobKey = $request->job_code;
        $job    = collect(JobType::cases())
            ->first(fn($j) => $j->name === $jobKey);
        if (! $job) {
            return $this->jsonResponse(['message' => '不正な職業'], 422);
        }

        // rank に応じてステータス生成（Seeder と同じロジック）
        $stats = $job->generateStats($request->rank, 0.1);

        // 新規プレイヤー作成
        $person                = new Person();
        $person->name          = $request->name;
        $person->job           = $job->value;
        $person->rank          = $request->rank;
        $person->location_code = $request->location_code;
        $person->lv            = 1;
        $person->exp           = 0;

        // ステータスセット
        $person->hp           = $stats['hp'];
        $person->mp           = $stats['mp'];
        $person->strength     = $stats['strength'];
        $person->intelligence = $stats['intelligence'];
        $person->defense      = $stats['defense'];
        $person->resist       = $stats['resist'];
        $person->agility      = $stats['agility'];

        // id 最大値+1 を取得して PG### 形式で code を生成
        $maxId        = Person::max('id') ?? 0;
        $number       = $maxId + 1;
        $code         = 'PG' . str_pad($number, 3, '0', STR_PAD_LEFT);
        $person->code = $code;

        $person->save();

        return $this->jsonResponse(['message' => 'プレイヤーを作成しました', 'person' => $person]);
    }

    public function move(Request $request, Person $person)
    {
        $request->validate([
            'destination_code' => 'required|string|exists:locations,code',
        ]);

        $destination = Location::where('code', $request->destination_code)->firstOrFail();

        $currentLocation = $person->location;

        if ($currentLocation->faction_code !== $destination->faction_code) {
            return $this->jsonResponse(['message' => '他勢力への移動はできません'], 403);
        }

        $person->location_code = $destination->code;
        $person->save();

        return $this->jsonResponse(['message' => '移動完了', 'person' => $person]);
    }
}
