@extends('app')

@section('title', ' | Zápasy')

@section('content')

<h2>{{ $title }}</h2>

<div class="flex flex-align-i-stretch flex-gap-5 playoffs-tree-container">

    @foreach ($stages as $stage)
    
        <div class="flex flex-column flex-justify-space-around">
    
            @foreach($games->where('stage_id', $stage->id) as $game)
            @php
                $isSuccess = false;
                $isHomeEliminated = $isAwayEliminated = false;
                if ($game->points > 0) $isSuccess = true;
                if ($game->advancing_team_id === $game->home_team_id) $isAwayEliminated = true;
                if ($game->advancing_team_id === $game->away_team_id) $isHomeEliminated = true;
            @endphp
        
            <div class="box">
                <a href="{{ route('game', $game->id) }}">
                    <table class="palyoffs-table">
                        <tr>
                            <td colspan="3">
                                <div class="date">{{ \Carbon\Carbon::parse($game->game_date)->format($date_format) }}</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span @class(['flex flex-align-c-center gamebox flex-gap-3', 'eliminated' => $isHomeEliminated])>
                                    <img src="/img/teams/{{ $game->homeTeam->abbreviation }}.png" class="team-flag" alt="{{ $game->homeTeam->abbreviation }}"> <span>{{ $game->homeTeam->name }}</span>
                                </span>
                            </td>
                            <td>
                                <span @class(['flex flex-align-c-center', 'eliminated' => $isHomeEliminated])>{{ $game->home_team_goals }}</span>
                            </td>
                            <td rowspan="2" class="prediction text-center">
                                <span @class(['badge', 'success' => $isSuccess])>{{ (isset($game->home_team_goals)) ? $game->points : '' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span @class(['flex flex-align-c-center gamebox flex-gap-3', 'eliminated' => $isAwayEliminated])>
                                    <img src="/img/teams/{{ $game->awayTeam->abbreviation }}.png" class="team-flag" alt="{{ $game->awayTeam->abbreviation }}"> <span>{{ $game->awayTeam->name }}</span>
                                </span>
                            </td>
                            <td>
                                <span @class(['flex flex-align-c-center', 'eliminated' => $isAwayEliminated])>{{ $game->away_team_goals }}</span>
                            </td>
                        </tr>
                    </table>
                </a>
            </div>
        
            @endforeach
    
        </div>
    
    @endforeach

</div>

@endsection