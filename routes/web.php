<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HackathonController;

Route::get('/', function () {
    return view('welcome');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas Autenticadas Gerais
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/aluno', [DashboardController::class, 'aluno'])->name('dashboard.aluno');
});

// Rotas do Professor
Route::middleware(['auth', 'role:professor'])
    ->prefix('dashboard/professor') // Adiciona o prefixo 'dashboard/professor' a todas as rotas deste grupo
    ->group(function () {
        
        // Rota principal do Dashboard: /dashboard/professor
        Route::get('/', [DashboardController::class, 'professor'])->name('dashboard.professor');

        // Rotas de Hackathon: /dashboard/professor/hackathons
        Route::get('/hackathons', [HackathonController::class, 'index'])->name('hackathons.index');
        Route::post('/hackathons', [HackathonController::class, 'store'])->name('hackathons.store');
    });

// Rotas de Admin
Route::middleware(['auth', 'role:adm'])->group(function () {
    Route::resource('users', UserController::class);
});