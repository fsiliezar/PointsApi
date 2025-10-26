<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PointController;


Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['auth:api'])->group(function () {
Route::get('/points', [PointController::class, 'index']);
Route::get('/points/{id}', [PointController::class, 'show']);
Route::post('/points', [PointController::class, 'store']);
Route::put('/points/{id}', [PointController::class, 'update']);
Route::delete('/points/{id}', [PointController::class, 'destroy']);
});