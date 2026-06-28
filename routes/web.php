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
    Route::livewire('/user/{user}', ViewUser::class)->name('user');
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