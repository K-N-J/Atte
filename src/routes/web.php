<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AttendController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAllController;

// Laravel Breezeのルート定義
require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/stamp', [AuthenticatedSessionController::class, 'stamp'])
        ->name('stamp');

    Route::get('/date', [DateController::class, 'date'])
        ->name('date');

    Route::get('/user', [UserController::class, 'user'])
        ->name('user');

    Route::get('/userDetails/{userId}', [UserController::class, 'userDetails'])
        ->name('userDetails');

    Route::get('/userAll', [UserAllController::class, 'userAll'])
        ->name('userAll');

    Route::post('/attend/start', [AttendController::class, 'attendStart'])
        ->name('attend-start');

    Route::post('/attend/end', [AttendController::class, 'attendEnd'])
        ->name('attend-end');

    Route::post('/rest/start', [RestController::class, 'restStart'])
        ->name('rest-start');

    Route::post('/rest/end', [RestController::class, 'restEnd'])
        ->name('rest-end');
});

Route::get('/thanks', [AuthenticatedSessionController::class, 'thanks'])->name('thanks');
Route::get('/emailCheck', [AuthenticatedSessionController::class, 'emailCheck'])->name('emailCheck');