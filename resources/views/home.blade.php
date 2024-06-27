@extends('app')

@section('title', ' | Zápasy')

@section('content')

<h2>{{ $title }}</h2>

<div class="box size-xs">

    @if($games->isNotEmpty())

    <table class="games-table">
        <tr>
            <th>Zápas</th>
            <th class="prediction">Správne tipy</th>
        </tr>
    
        @foreach($games as $game)
        @php
            $isScore = $isSuccess = false;
            if ($game->game_predictions_sum_points > 0) $isSuccess = true;
        @endphp
    
        <tr>
            <td>
                <a href="{{ route('game', $game->id) }}">
                    <div class="date">{{ \Carbon\Carbon::parse($game->game_date)->format($date_format) }}</div>
                    <div class="game flex flex-column">
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $game->homeTeam->abbreviation }}.png" class="team-flag" alt="{{ $game->homeTeam->abbreviation }}"> {{ $game->homeTeam->name }}</span>
                            <span>{{ $game->home_team_goals }}</span>
                        </div>
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $game->awayTeam->abbreviation }}.png" class="team-flag" alt="{{ $game->awayTeam->abbreviation }}"> {{ $game->awayTeam->name }}</span>
                            <span>{{ $game->away_team_goals }}</span>
                        </div>
                    </div>
                </a>
            </td>
            <td class="prediction text-center">
                <span @class(['badge', 'success' => $isSuccess])>{{ $game->game_predictions_sum_points }}</span>
                <a href="{{ route('game', $game->id) }}">
                    <i></i>
                </a>
            </td>
        </tr>
    
        @endforeach
    
    </table>

    @else

    <div class="text-center">
        Dnes nie sú na programe žiadne zápasy
    </div>

    @endif

</div>
<h2>Top 3 tipéri</h2>
<div class="box size-xs">
    <table>
        <tr>
            <th>Por.</th>
            <th>Meno</th>
            <th>Body</th>
        </tr>
    
    @foreach ($users as $user)

    <tr class="standing position{{$loop->index + 1}}">
        <td class="rank text-center">{{ $loop->index + 1 }}.</td>
        <td>
            <a href="{{ route('user', $user->id) }}">
                {{ $user->name }}
            </a>
        </td>
        <td class="text-center">{{ $user->points }}</td>
    </tr>

    @endforeach
    
    </table>
</div>


@endsection