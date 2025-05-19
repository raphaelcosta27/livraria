<?php

use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('livraria.welcome'));

/*
|--------------------------------------------------------------------------
| Dashboard e Painel
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', fn () => redirect()->route('livraria.home'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/painel', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('livraria.home');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (usuário autenticado e verificado)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recursos principais
    Route::resource('assuntos', AssuntoController::class);
    Route::resource('autores', AutorController::class)->parameters([
        'autores' => 'autor',
    ]);
    Route::resource('livros', LivroController::class);

    // Relatórios
    Route::view('/relatorios/livros-autores', 'livraria.relatorios.view-livros-autores')
        ->name('relatorios.livros-autores');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação (Breeze/Fortify/etc)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
