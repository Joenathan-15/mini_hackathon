<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post("/login", [AuthController::class, 'login'])->name('login.post');
    Route::post("/register", [AuthController::class, 'storeUser'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
    Route::view('/profile', 'pages.profile')->name('profile');
    Route::view('/settings', 'pages.settings')->name('materials.index');
    Route::post("/logout", [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('landing');
})->name('landing');


Route::get('/profile', function () {
    return view('profile');
})->name('profile');
