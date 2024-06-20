@extends('app')

@section('title', ' | Pridať tip')

@section('content')

<form action="{{ route('prediction.create') }}" method="post" class="box size-xs">
    <h2>Nový tip</h2>
    @csrf
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="user_id"><i class="fa-solid fa-user"></i></label>
        <select class="input-field text" name="user_id">
            <option value="">-- Vybrať --</option>
            @foreach ($users as $user)
    
            <option value="{{ $user->id }}">{{ $user->name }}</option>
    
            @endforeach
        </select>
        <label class="flex flex-justify-center flex-align-i-center" for="game_id"><i class="fa-solid fa-trophy"></i></label>
        <select class="input-field text field-medium" name="game_id">
            <option value="">-- Vybrať --</option>
            @foreach ($games as $game)
    
            <option value="{{ $game->id }}">{{ $game->homeTeam->name }} - {{ $game->awayTeam->name }}</option>
    
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="home_team_goals"><i class="fa-solid fa-futbol"></i></label>
        <input class="input-field number" type="number" name="home_team_goals">
        <label class="flex flex-justify-center flex-align-i-center" for="away_team_goals"><i class="fa-solid fa-minus"></i></label>
        <input class="input-field number" type="number" name="away_team_goals">
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