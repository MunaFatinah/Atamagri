<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\LandingController;


Route::get('/', [LandingController::class, 'index'])->name('landing');


Route::get('/cuaca', [WeatherController::class, 'index'])->name('cuaca');
Route::post('/api/cuaca', [WeatherController::class, 'fetch'])->name('api.cuaca');


Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi');
Route::post('/api/rekomendasi', [RekomendasiController::class, 'fetch'])->name('api.rekomendasi');


Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store')->middleware('auth');


Route::get('/login', [AuthController::class, 'loginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'registerForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:petani'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/cuaca', [DashboardController::class, 'cuaca'])->name('cuaca');
    Route::get('/rekomendasi', [DashboardController::class, 'rekomendasi'])->name('rekomendasi');
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::put('/profil', [DashboardController::class, 'updateProfil'])->name('profil.update');

    Route::post('/api/cuaca', [WeatherController::class, 'fetchDash'])->name('api.cuaca');
    Route::post('/api/rekomendasi', [RekomendasiController::class, 'fetchDash'])->name('api.rekomendasi');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/stats', [AdminController::class, 'stats'])->name('stats');
});
