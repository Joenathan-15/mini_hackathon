<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialDetailController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInfoController;

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

Route::middleware('auth')->group(function () {
    Route::resource('materials', MaterialController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('material-details', MaterialDetailController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('users', UserController::class);
    Route::resource('user-infos', UserInfoController::class);
});
