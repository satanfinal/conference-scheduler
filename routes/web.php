<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\rsvpController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');

    Route::resource('speakers', SpeakerController::class);
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/speakers/{speaker}/create-account', [SpeakerController::class, 'createAccount'])
    ->name('speakers.createAccount');

    Route::post('/events/{eventId}/rsvp', [rsvpController::class, 'store'])->name('rsvp.store');
    Route::delete('/events/{eventId}/rsvp', [rsvpController::class, 'destroy'])->name('rsvp.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});