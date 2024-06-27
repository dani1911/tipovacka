@extends('app')

@section('title', ' | ' . Str::upper($game->homeTeam->abbreviation) . '-' . Str::upper($game->awayTeam->abbreviation))

@section('content')

<div class="flex flex-justify-space-between size-xs">
    <div>
        <img src="/img/teams/{{ $game->homeTeam->abbreviation }}.png" alt="{{ $game->homeTeam->abbreviation }}">
    </div>
    <div class="game-details">
        <div class="game-teams text-center">
            <h2>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</h2>
        </div>
        <div class="game-data text-center">
            @if (empty($game->final_result))
                <span class="date">{{ \Carbon\Carbon::parse($game->game_date)->format('d. m. Y H:i') }}</span>
            @else
                <span class="badge success">{{ $game->final_result }}</span>
            @endif
        </div>
    </div>
    <div>
        <img src="/img/teams/{{ $game->awayTeam->abbreviation }}.png" alt="{{ $game->awayTeam->abbreviation }}">
    </div>
</div>

@if (Auth::check() && Auth::user()->id === 1)

    @include('_partials.game.edit')

@endif

<div class="box size-xs">
    <table>
        <tr>
            <th>Meno</th>
            <th class="text-center">Tip</th>

            @if ($game->stage_id > 6)
                
            <th class="text-center"></th>

            @endif
        </tr>
    
    @foreach ($game->gamePredictions->sortBy('user.name', SORT_NATURAL|SORT_FLAG_CASE) as $prediction)
    @php
        $isSuccess = $isFail = false;
        if ($game->home_team_goals === $prediction->home_team_goals && $game->away_team_goals === $prediction->away_team_goals) $isSuccess = true;
    @endphp

    <tr>
        <td><a href="{{ route('user', $prediction->user->id) }}">{{ $prediction->user->name }}</a></td>
        <td class="text-center"><span @class(['badge', 'success' => $isSuccess])>{{ $prediction->score }}</span></td>

        @if ($game->stage_id > 6)

        <td>
            <div class="flex flex-justify-center flex-align-i-center flex-gap-5">

                <img src="/img/teams/{{ $prediction->advancingTeam->abbreviation }}.png" class="team-flag" alt="{{ $prediction->advancingTeam->abbreviation }}">
            
                @if (null !== $game->advancing_team_id && $prediction->advancing_team_id === $game->advancing_team_id)
                <i class="fa-solid fa-circle-check"></i>
                @elseif (null !== $game->advancing_team_id)
                <i class="fa-solid fa-circle-xmark"></i>
                @endif

            </div>

        </td>

        @endif

    </tr>
    
    @endforeach
    
    </table>
</div>

@endsection