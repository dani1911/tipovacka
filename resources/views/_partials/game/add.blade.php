@extends('app')

@section('title', ' | Pridať zápas')

@section('content')

<form action="{{ route('game.create') }}" method="post" class="box">
    <h2>Nový zápas</h2>
    @csrf
    <input class="input-field text" type="datetime-local" name="game_date">
    <select class="input-field text" name="home_team">
        <option value="">-- Vybrať --</option>
        @foreach ($teams as $team)

        <option value="{{ $team->id }}">{{ $team->name }}</option>

        @endforeach
    </select>
    <select class="input-field text" name="away_team">
        <option value="">-- Vybrať --</option>
        @foreach ($teams as $team)

        <option value="{{ $team->id }}">{{ $team->name }}</option>

        @endforeach
    </select>
    <input class="btn btn-primary" type="submit" value="Pridať">
</form>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@endsection