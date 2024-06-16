@extends('app')

@section('title', ' | ' . $user->name)

@section('content')

<div class="user-title size-xs flex flex-justify-space-around">
    <h2>{{ $user->name }}</h2><span class="badge success">{{ $user->points }}</span>
</div>

<div class="box size-xs user-stage-predictions">
    <h3>Tipy na víťazov</h3>
    <table>
        <tr>
            <th class="stage">Fáza</th>
            <th>Tip</th>
            <th></th>
        </tr>
    
    @foreach ($user_predictions->stagePredictions as $stage)
    
        <tr>
            <td class="stage">{{ $stage->stage_name }}</td>
            <td>{{ $stage->team->name }}</td>
            <td>
                @if ($stage->points === 1)
                <i class="fa-solid fa-circle-check"></i>
                @elseif ($stage->points === 0)
                <i class="fa-solid fa-circle-xmark"></i>
                @endif
            </td>
        </tr>
        
    @endforeach
    
    </table>
    <div class="vertical-scroll-table">
        <div class="inner-scroll">
        </div>
    </div>
</div>
<div class="box size-xs">
    <h3>Tipy na zápasy</h3>
    <table>
        <tr>
            <th>Zápas</th>
            <th>Tip</th>
        </tr>
    
    @foreach ($user_predictions->gamePredictions as $prediction)
    
        @php
            $isSuccess = $isFail = false;
            if ($prediction->points === 1) $isSuccess = true;
            if ($prediction->points === 0) $isFail = true;
        @endphp
    
        <tr>
            <td>
                <a href="{{ route('game', $prediction->game->id) }}">
                    <div class="date">{{ \Carbon\Carbon::parse($prediction->game->game_date)->format($date_format) }}</div>
                    <div class="game flex flex-column">
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $prediction->game->homeTeam->abbreviation }}.png" class="team-flag" alt="{{ $prediction->game->homeTeam->name }}"> {{ $prediction->game->homeTeam->name }}</span>
                            <span>{{ $prediction->game->home_team_goals }}</span>
                        </div>
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $prediction->game->awayTeam->abbreviation }}.png" class="team-flag" alt="{{ $prediction->game->awayTeam->abbreviation }}"> {{ $prediction->game->awayTeam->name }}</span>
                            <span>{{ $prediction->game->away_team_goals }}</span>
                        </div>
                    </div>
                </a>
            </td>
            <td class="prediction text-center">
                <span @class(['badge', 'success' => $isSuccess, 'fail' => $isFail])>{{ $prediction->score }}</span>
            </td>
        </tr>
    
    @endforeach
    
    </table>
</div>

@endsection