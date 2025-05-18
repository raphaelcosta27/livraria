<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssuntoController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('livraria.home');
    }

    return view('livraria.welcome');
});

Route::get('/dashboard', function () {
    // return view('dashboard');
    return redirect()->route('livraria.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/painel', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('livraria.home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Assuntos
    Route::resource('assuntos', AssuntoController::class);

    //Autores
    Route::resource('autores', AutorController::class)->parameters([
        'autores' => 'autor',
    ]);

    //Livros
    Route::resource('livros', LivroController::class);

    Route::get('/relatorios/livros-autores', function () {
        return view('livraria.relatorios.view-livros-autores');
    })->name('relatorios.livros-autores');
});

require __DIR__.'/auth.php';
