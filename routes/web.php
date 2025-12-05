<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\GrupoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth']) 
    ->prefix('dashboard/aluno')
    ->group(function () {
        

        Route::get('/', [DashboardController::class, 'aluno'])->name('dashboard.aluno');

        Route::get('/hackathon', [HackathonController::class, 'alunoIndex'])->name('aluno.hackathons.index');
        Route::get('/grupos', [GrupoController::class, 'index'])->name('grupos.index');
        Route::post('/grupos', [GrupoController::class, 'store'])->name('grupos.store');
        Route::post('/grupos/join', [GrupoController::class, 'join'])->name('grupos.join');
    });

Route::middleware(['auth', 'role:professor'])
    ->prefix('dashboard/professor')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'professor'])->name('dashboard.professor');
        

        Route::get('/hackathons', [HackathonController::class, 'index'])->name('hackathons.index');
        Route::post('/hackathons', [HackathonController::class, 'store'])->name('hackathons.store');
        Route::put('/hackathons/{hackathon}', [HackathonController::class, 'update'])->name('hackathons.update');
    });


Route::middleware(['auth', 'role:adm'])->group(function () {
    Route::resource('users', UserController::class);
});