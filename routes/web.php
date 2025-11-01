<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Material\MaterialController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post("/login", [AuthController::class, 'login'])->name('login.post');
    Route::post("/register", [AuthController::class, 'storeUser'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/profile', 'pages.profile')->name('profile');
    Route::post("/logout", [AuthController::class, 'logout'])->name('logout');

    Route::view('/upload', 'upload')->name('materials.create');
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
});

Route::get('/', function () {
    return view('landing');
})->name('landing');
