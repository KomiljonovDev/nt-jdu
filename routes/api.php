<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleUserController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('subjects', SubjectController::class);

    Route::resource('role-user', RoleUserController::class);
    Route::resource('schedules', ScheduleController::class);

});
