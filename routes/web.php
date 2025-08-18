<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\PersonSkillController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/battle/{location1}/{location2}', function () {
    return view('welcome');
});
Route::get('/tactics', function () {
    return view('welcome');
});

Route::get('/people', function () {
    return view('welcome');
});

Route::get('/api/locations/{locationCode}/candidates', [LocationController::class, 'getCandidates']);
Route::apiResource('/api/locations', LocationController::class);

Route::delete('/api/people/{person}/skills/{skill}', [PersonSkillController::class, 'destroy']);
Route::post('/api/people/{person}/skills', [PersonSkillController::class, 'store']);

Route::put('/api/people/{person}/move', [PersonController::class, 'move']);
Route::get('/api/people', [PersonController::class, 'index']);

Route::get('/api/skills', [SkillController::class, 'index']);
