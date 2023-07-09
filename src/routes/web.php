<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/stamp', [AuthenticatedSessionController::class, 'stamp'])
        ->name('stamp');
    Route::get('/date', [DateController::class, 'date'])
        ->name('date');
    Route::get('/user', [UserController::class, 'user'])
        ->name('user');
    Route::post('/attend/start', [AttendController::class, 'attendStart'])
        ->name('attend-start');
    Route::post('/attend/end', [AttendController::class, 'attendEnd'])
        ->name('attend-end');
    Route::post('/rest/start', [RestController::class, 'restStart'])
        ->name('rest-start');
    Route::post('/rest/end', [RestController::class, 'restEnd'])
        ->name('rest-end');
    }
);

Route::get('/thanks', [AuthenticatedSessionController::class, 'thanks'])->name('thanks');
