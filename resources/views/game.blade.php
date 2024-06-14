@extends('app')

@section('title', ' | ' . Str::upper($game->homeTeam->abbreviation) . '-' . Str::upper($game->awayTeam->abbreviation))

@section('content')

<h2>{{ $game->homeTeam->name }} vs {{ $game->awayTeam->name }}</h2>
<h3>{{ $game->final_result }}</h3>
@if (Auth::user()->id === 1)

    @include('_partials.game.edit')

@endif
<table>
    <tr>
        <th>Meno</th>
        <th>Tip</th>
    </tr>

@foreach ($game->gamePredictions as $prediction)

    @php
        $isSuccess = $isFail = false;
        if ($prediction->points === 1) $isSuccess = true;
        if ($prediction->points === 0) $isFail = true;
    @endphp

    <tr>
        <td>{{ $prediction->user->name }}</td>
        <td><span @class(['badge', 'success' => $isSuccess, 'fail' => $isFail])>{{ $prediction->score }}</span></td>
    </tr>

@endforeach

</table>

@endsection