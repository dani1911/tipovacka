@extends('app')

@section('title', ' | Pridať zápas')

@section('content')

<form action="{{ route('game.create') }}" method="post" class="box size-xs">
    <h2>Nový zápas</h2>
    @csrf
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="game_date"><i class="fa-solid fa-calendar-days"></i></label>
        <input class="input-field text" type="datetime-local" name="game_date">
    </fieldset>
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="home_team"><i class="fa-solid fa-shirt"></i></label>
        <select class="input-field text" name="home_team">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>

            @endforeach
        </select>
        <label class="flex flex-justify-center flex-align-i-center" for="away_team"><i class="fa-solid fa-shirt"></i></label>
        <select class="input-field text" name="away_team">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>

            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-justify-center flex-no-gap">
        <input class="btn btn-primary" type="submit" value="Pridať">
    </fieldset>
</form>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@endsection