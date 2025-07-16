<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\ActivityController;

use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\AuthenticateWithApiToken;

// ===================
// AUTHENTICATION ROUTES
// ===================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// ===================
// GET CURRENT USER
// ===================

Route::middleware([CheckAuthenticated::class, AuthenticateWithApiToken::class])
    ->get('/me', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    });

// ===================
// PROTECTED ROUTES
// ===================


Route::middleware([CheckAuthenticated::class, AuthenticateWithApiToken::class])->group(function () {
    Route::get('/schedules', [ScheduleController::class, 'index']);
    Route::post('/schedules', [ScheduleController::class, 'store']);
    Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);
    Route::put('/schedules/check/{id}', [ScheduleController::class, 'updateChecklist']);

    Route::get('/notes/search', [NotesController::class, 'search']);
    Route::apiResource('notes', NotesController::class);

    // DAILY
    Route::get('/daily', [DailyController::class, 'index']);
    Route::post('/daily', [DailyController::class, 'store']);
    Route::get('/daily/{id}', [DailyController::class, 'show']);
    Route::put('/daily/{id}', [DailyController::class, 'update']);
    Route::delete('/daily/{id}', [DailyController::class, 'destroy']);

    // CHECKLIST ROUTE
    Route::put('/daily/check/{id}', [DailyController::class, 'updateChecklist']);
    Route::put('/schedules/check/{id}', [ScheduleController::class, 'updateChecklist']);

    // ACTIVITY
    Route::get('/activity', [ActivityController::class, 'index']);
    Route::post('/activity', [ActivityController::class, 'store']);
    Route::put('/activity/{id}', [ActivityController::class, 'update']);
    Route::delete('/activity/{id}', [ActivityController::class, 'destroy']);
    Route::get('/activity-all', [ActivityController::class, 'all']);
});
