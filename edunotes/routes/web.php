<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Rute Landing Page (Halaman Depan)
Route::get('/', function () {
    return view('homepage');
});

// 2. Rute Autentikasi (Login & Register)
Route::get('/login', function () {
    return view('pages.auth.login');
});

Route::get('/register', function () {
    return view('pages.auth.register');
});

// 3. Rute Dasbor Utama
Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
});

// Rute untuk memproses form (POST)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Rute Dasbor Utama (Dikunci hanya untuk yang sudah login)
Route::get('/dashboard', function () {
    return view('pages.user.dashboard');
})->middleware('auth');

// Rute API untuk Manajemen Tugas (Hanya untuk yang login)
Route::middleware('auth')->group(function () {
    Route::get('/api/tasks', [TaskController::class, 'index']);
    Route::post('/api/tasks', [TaskController::class, 'store']);
    Route::post('/api/tasks/{id}/status', [TaskController::class, 'updateStatus']);
    Route::post('/api/tasks/destroy-all', [TaskController::class, 'destroyAll']);
});