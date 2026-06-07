<?php

use App\Http\Middleware\ResolveTournament;
use App\Livewire\Games\ListGames;
use App\Livewire\Games\ViewGame;
use App\Livewire\Groups\ListGroups;
use App\Livewire\Home\HomeView;
use App\Livewire\Knockout\Bracket;
use App\Livewire\Tournaments\ListTournaments;
use App\Livewire\Users\ListUsers;
use App\Livewire\Users\ViewUser;
use Illuminate\Support\Facades\Route;


Route::middleware(ResolveTournament::class)->group(function () {
    Route::livewire('/', HomeView::class)->name('home');
    Route::livewire('/games', ListGames::class)->name('games');
    Route::livewire('/groups', ListGroups::class)->name('groups');
    Route::livewire('/knockout', Bracket::class)->name('knockout');
    Route::livewire('/users', ListUsers::class)->name('users');
});

Route::livewire('/tournaments', ListTournaments::class)->name('tournaments');

Route::prefix('{tournament:slug}')
    ->middleware(ResolveTournament::class)
    ->scopeBindings()
    ->group(function () {
        Route::livewire('/games', ListGames::class)->name('tournament.games');
        Route::livewire('/game/{game:id}', ViewGame::class)->name('tournament.game');
        Route::livewire('/groups', ListGroups::class)->name('tournament.groups');
        Route::livewire('/knockout', Bracket::class)->name('tournament.knockout');
        Route::livewire('/users', ListUsers::class)->name('tournament.users');
        Route::livewire('/user/{user}', ViewUser::class)->name('tournament.user');
    });

// Route::controller(AuthController::class)->group(function () {
//     Route::get('/', [HomeController::class, 'index'])->name('home');
//     Route::get('/games', [GameController::class, 'index'])->name('games');
//     Route::get('/game/{id}', [GameController::class, 'show'])->name('game');
//     Route::get('/playoffs', [GameController::class, 'playoffs'])->name('playoffs');
//     Route::get('/standings', [UserController::class, 'index'])->name('standings');
//     Route::get('/user/{id}', [UserController::class, 'show'])->name('user');
//     Route::get('/stage', [StageController::class, 'index'])->name('stage');
//     // Route::get('/register', 'registerForm')->name('register');
//     // Route::post('/register', 'register')->name('new_user');
//     Route::get('/login', 'loginForm')->name('view_login');
//     Route::post('/login', 'login')->name('login');
//     // Route::middleware(['guest'])->group(function()
//     // {
//     // });
//     Route::post('/home/update', [HomeController::class, 'ajaxChangeStandingsContent']);
//     Route::post('/user/{id}/update', [UserController::class, 'ajaxChangePageContent']);
//     Route::post('/standings/update', [UserController::class, 'ajaxChangeStandingsContent']);
//     Route::post('/logout', 'logout')->name('logout');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/users/add', [UserController::class, 'create'])->name('user.add');
//     Route::post('/user/create', [UserController::class, 'store'])->name('user.create');
//     Route::get('/stage/update', [StageController::class, 'edit'])->name('stage.edit');
//     Route::post('/stage/save', [StageController::class, 'store'])->name('stage.store');
//     Route::get('/games/add', [GameController::class, 'create'])->name('game.add');
//     Route::post('/game/create', [GameController::class, 'store'])->name('game.create');
//     Route::post('/game/{id}', [GameController::class, 'update'])->name('game.update');
//     Route::get('/predictions/add', [GamePredictionController::class, 'create'])->name('prediction.add');
//     Route::post('/prediction/create', [GamePredictionController::class, 'store'])->name('prediction.create');
//     Route::post('/predictions/ajaxGetTeams', [GamePredictionController::class, 'ajaxGetTeams']);
// });