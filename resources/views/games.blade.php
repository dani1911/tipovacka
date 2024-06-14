@extends('app')

@section('title', ' | Zápasy')

@section('content')

<h2>{{ $title }}</h2>

<table class="games-table">
    <tr>
        <th>Dátum</th>
        <th>Zápas</th>
        <th>Správne tipy</th>
        <th>Výsledok</th>
    </tr>

    @foreach($games as $game)

    <tr>
        <td>{{ \Carbon\Carbon::parse($game->game_date)->format('d. m. Y H:i') }}</td>
        <td>
            <a href="{{ route('game', $game->id) }}">
                {{ $game->homeTeam->name }} - {{ $game->awayTeam->name }}
            </a>
        </td>
        <td>
            <span class="badge">{{ $game->game_predictions_sum_points }}</span>
            <a href="{{ route('game', $game->id) }}">
                <i></i>
            </a>
        </td>
        <td>{{ $game->final_result }}</td>
    </tr>

    @endforeach

</table>

@endsection