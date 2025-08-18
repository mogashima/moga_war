<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Models\LocationConnection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * 一覧取得
     */
    public function index()
    {
        $locations = Location::select('id', 'code', 'name', 'pos_x', 'pos_y', 'faction_code')
            ->with([
                'faction:id,code,name,color',
                'neighbors:id,from_location_code,to_location_code',
                'neighbors.toLocation:id,code,name,pos_x,pos_y,faction_code'
            ])->get();

        return $this->jsonResponse($locations);
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
        return $this->jsonResponse($location, 201);
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
        return $this->jsonResponse($location);
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

    public function getCandidates($locationCode)
    {
        $candidates = Location::join('location_connections', 'locations.code', '=', 'location_connections.to_location_code')
            ->where('location_connections.from_location_code', $locationCode)
            ->where('faction_code', function ($sub) use ($locationCode) {
                $sub->select('faction_code')
                    ->from('locations')
                    ->where('code', $locationCode)
                    ->limit(1);
            })
            //->select() // 返すのは隣接拠点
            ->get();

        return $this->jsonResponse($candidates);
    }
}
