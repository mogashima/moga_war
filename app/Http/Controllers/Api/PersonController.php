<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class PersonController extends Controller
{
    public function index(): JsonResponse
    {
        return $this->jsonResponse(Person::with('skills')->get());
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
