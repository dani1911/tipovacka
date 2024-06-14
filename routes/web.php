<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function()
{
    Route::middleware(['guest'])->group(function()
    {
    //    Route::get('/register', 'registerForm')->name('register');
    //    Route::post('/register', 'register')->name('new_user');
        Route::get('/login', 'loginForm')->name('view_login');
        Route::post('/login', 'login')->name('login');
    });
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware(['auth'])->group(function()
{
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/games', [GameController::class, 'index'])->name('games');
    Route::get('/game/{id}', [GameController::class, 'show'])->name('game');
    Route::get('/game/{id}/update', [GameController::class, 'edit'])->name('game.edit');
    Route::post('/game/{id}', [GameController::class, 'update'])->name('game.update');
    Route::get('/standings', [UserController::class, 'index'])->name('standings');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user');
});

