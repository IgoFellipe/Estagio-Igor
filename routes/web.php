<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/aluno', [DashboardController::class, 'aluno'])->name('dashboard.aluno');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/professor', [DashboardController::class, 'professor'])->name('dashboard.professor');
});

Route::middleware(['auth', 'role:adm'])->group(function () {
    Route::resource('users', UserController::class);
});
