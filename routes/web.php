<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'pages.auth.login')->name('login');
    Route::view('/register', 'pages.auth.register')->name('register');

    Route::post("/login", [AuthController::class, 'login'])->name('login.post');
    Route::post("/register", [AuthController::class, 'storeUser'])->name('register.post');
});

Route::get('/', function () {
    return view('welcome');
});
