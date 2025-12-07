<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/register', [GameController::class, 'register'])->name('games.register');
Route::post('/games', [GameController::class, 'store'])->name('games.store');