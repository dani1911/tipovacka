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
        </tr>
    
    @foreach ($game->gamePredictions->sortBy('user.name', SORT_NATURAL|SORT_FLAG_CASE) as $prediction)
    @php
        $isSuccess = $isFail = false;
        if ($prediction->points === 1) $isSuccess = true;
    @endphp

    <tr>
        <td><a href="{{ route('user', $prediction->user->id) }}">{{ $prediction->user->name }}</a></td>
        <td class="text-center"><span @class(['badge', 'success' => $isSuccess])>{{ $prediction->score }}</span></td>
    </tr>
    
    @endforeach
    
    </table>
</div>

@endsection