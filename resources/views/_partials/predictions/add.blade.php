@extends('app')

@section('title', ' | Pridať tip')

@section('content')

<form action="{{ route('prediction.create') }}" method="post" class="box">
    <h2>Nový zápas</h2>
    @csrf
    <select class="input-field text" name="user_id">
        <option value="">-- Vybrať --</option>
        @foreach ($users as $user)

        <option value="{{ $user->id }}">{{ $user->name }}</option>

        @endforeach
    </select>
    <select class="input-field text" name="game_id">
        <option value="">-- Vybrať --</option>
        @foreach ($games as $game)

        <option value="{{ $game->id }}">{{ $game->homeTeam->name }} - {{ $game->awayTeam->name }}</option>

        @endforeach
    </select>
    <input class="input-field number" type="number" name="home_team_goals">
    <input class="input-field number" type="number" name="away_team_goals">
    <input class="btn btn-primary" type="submit" value="Pridať">
</form>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@endsection