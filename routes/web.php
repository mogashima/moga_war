<?php

use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\PersonSkillController;
use App\Http\Controllers\Api\SkillController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('api')->group(function () {
    Route::prefix('locations')->group(function () {
        Route::get('{locationCode}/candidates', [LocationController::class, 'getCandidates']);
    });
    Route::apiResource('locations', LocationController::class);

    Route::delete('people/{person}/skills/{skill}', [PersonSkillController::class, 'destroy']);
    Route::post('people/{person}/skills', [PersonSkillController::class, 'store']);

    Route::put('people/{person}/move', [PersonController::class, 'move']);
    Route::get('people', [PersonController::class, 'index']);
    Route::post('people', [PersonController::class, 'store']);

    Route::get('skills', [SkillController::class, 'index']);
    Route::get('jobs', [JobController::class, 'index']);

    Route::post('/api/experience/training', [ExperienceController::class, 'training']);

});
