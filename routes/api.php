<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController as PostControllerV1;
use App\Http\Controllers\Api\V2\PostController as PostControllerV2;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas de la API versión 1
Route::prefix('v1')->group(function () {
    Route::apiResource('posts', PostControllerV1::class)
    ->only(['index', 'show', 'destroy'])
    ->middleware('auth:sanctum');
});

// Rutas de la API versión 2
Route::prefix('v2')->group(function () {
    Route::apiResource('posts', PostControllerV2::class)
    ->only(['index', 'show'])
    ->middleware('auth:sanctum');
});
