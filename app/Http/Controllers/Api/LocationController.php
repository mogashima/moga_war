<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * 一覧取得
     */
    public function index()
    {
        return $this->jsonResponse(Location::with('faction')->get());
    }

    /**
     * 新規作成
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pos_x' => 'required|integer',
            'pos_y' => 'required|integer',
        ]);

        $location = Location::create($validated);
        return response()->json($location, 201);
    }

    /**
     * 単一取得
     */
    public function show($id)
    {
        $location = Location::with('people.skills')->findOrFail($id);
        return $this->jsonResponse($location);
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'pos_x' => 'integer',
            'pos_y' => 'integer',
        ]);

        $location->update($validated);
        return response()->json($location);
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json(['message' => 'Location deleted']);
    }

    public function getCandidates($factionCode)
    {
        $candidates = Location::where('faction_code', $factionCode)
            ->get();

        return response()->json($candidates);
    }
}
