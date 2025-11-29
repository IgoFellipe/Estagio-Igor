<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HackathonController;

Route::get('/', function () {
    return view('welcome');
});

// --- ROTAS DE AUTENTICAÇÃO ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ROTAS DO ALUNO ---
// Acessíveis apenas para alunos logados
Route::middleware(['auth']) // Se tiver um middleware 'role:aluno', adicione aqui
    ->prefix('dashboard/aluno')
    ->group(function () {
        
        // Dashboard Principal
        Route::get('/', [DashboardController::class, 'aluno'])->name('dashboard.aluno');

        // Listagem de Hackathons para o Aluno
        Route::get('/hackathon', [HackathonController::class, 'alunoIndex'])->name('aluno.hackathons.index');
    });

// --- ROTAS DO PROFESSOR ---
// Acessíveis apenas para professores logados
Route::middleware(['auth', 'role:professor'])
    ->prefix('dashboard/professor')
    ->group(function () {
        // Dashboard Principal
        Route::get('/', [DashboardController::class, 'professor'])->name('dashboard.professor');
        
        // Gerenciamento de Hackathons
        Route::get('/hackathons', [HackathonController::class, 'index'])->name('hackathons.index');
        Route::post('/hackathons', [HackathonController::class, 'store'])->name('hackathons.store');
    });

// --- ROTAS DO ADMINISTRADOR ---
// Acessíveis apenas para ADMs
Route::middleware(['auth', 'role:adm'])->group(function () {
    Route::resource('users', UserController::class);
});