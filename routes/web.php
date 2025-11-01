<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Material\MaterialController;
use App\Models\Material;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post("/login", [AuthController::class, 'login'])->name('login.post');
    Route::post("/register", [AuthController::class, 'storeUser'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $soldCount = Transaction::whereHas('material', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $income = Transaction::whereHas('material', function ($query) {
            $query->where('user_id', Auth::id());
        })->sum('price');
        $uploadCount = Material::where('user_id', Auth::id())->count();

        return view('dashboard', compact('soldCount', 'income', 'uploadCount'));
    })->name('dashboard');

    Route::view('/profile', 'profile')->name('profile');
    Route::post("/logout", [AuthController::class, 'logout'])->name('logout');

    Route::get('/material-purchases', [MaterialController::class, 'getPurchasesMaterial'])->name('material.purchases.index');
    Route::view('/upload', 'upload')->name('materials.create');
    Route::get('/my-materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials', [MaterialController::class, 'getMaterials'])->name('materials.get');
    Route::post('/material', [MaterialController::class, 'store'])->name('material.store');
});

Route::get('/detail', function () {
    return view('detail');
})->name('detail');

Route::get('/explore', function () {
    $materi = collect([]); // data kosong dulu biar gak error
    return view('explore', compact('materi'));
})->name('explore');


Route::get('/', function () {
    return view('landing');
})->name('landing');
