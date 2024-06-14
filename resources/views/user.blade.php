@extends('app')

@section('title', ' | ' . $user->name)

@section('content')

<h2>{{ $user->name }} <span class="badge">{{ $user->points }}</span></h2>

<h3>Tipy na víťazov:</h3>
<table>
    <tr>
        <th>Fáza</th>
        <th>Tip na víťaza</th>
        <th>Skutočný víťaz</th>
    </tr>

@foreach ($user_predictions->stagePredictions as $stage)

    <tr>
        <td>{{ $stage->stage }}</td>
        <td>{{ $stage->team->name }}</td>
        <td></td>
    </tr>
    
@endforeach

</table>
<h3>Tipy na zápasy:</h3>
<table>
    <tr>
        <th>Zápas</th>
        <th>Tip</th>
        <th>Výsledok</th>
    </tr>

@foreach ($user_predictions->gamePredictions as $prediction)

    @php
        $isSuccess = $isFail = false;
        if ($prediction->points === 1) $isSuccess = true;
        if ($prediction->points === 0) $isFail = true;
    @endphp

    <tr>
        <td>{{ $prediction->game->homeTeam->name }} - {{ $prediction->game->awayTeam->name }}</td>
        <td><span @class(['badge', 'success' => $isSuccess, 'fail' => $isFail])>{{ $prediction->score }}</span></td>
        <td>{{ $prediction->game->final_result }}</td>
    </tr>

@endforeach

</table>

@endsection