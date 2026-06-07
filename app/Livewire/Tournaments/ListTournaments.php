<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use Livewire\Component;

class ListTournaments extends Component
{
    public function mount()
    {
        view()->share('tournament', null);
    }

    public function render()
    {
        $tournaments = Tournament::all();
        
        return view('livewire.tournaments.list-tournaments', compact('tournaments'));
    }
}