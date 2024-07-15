<form action="{{ route('game.update', ['id' => $game->id]) }}" method="post" class="box size-xs">
    @csrf

    @if ( $game->home_team_id === 25 || $game->away_team_id === 25 )

    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="home_team"><i class="fa-solid fa-shirt"></i></label>
        <select class="input-field text" name="home_team">
            <option value="{{ $game->home_team_id }}">{{ $game->homeTeam->name }}</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>

            @endforeach
        </select>
        <label class="flex flex-justify-center flex-align-i-center" for="away_team"><i class="fa-solid fa-shirt"></i></label>
        <select class="input-field text" name="away_team">
            <option value="{{ $game->away_team_id }}">{{ $game->awayTeam->name }}</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>

            @endforeach
        </select>
    </fieldset>

    @else
        
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="home_team_goals"><i class="fa-solid fa-futbol"></i></label>
        <input class="input-field number" type="number" name="home_team_goals">
        <label class="flex flex-justify-center flex-align-i-center" for="away_team_goals"><i class="fa-solid fa-minus"></i></label>
        <input class="input-field number" type="number" name="away_team_goals">
    </fieldset>

    @if (in_array($game->stage_id, [7,8,9,11]))
    
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="advancing_team"><i class="fa-solid fa-trophy"></i></label>
        <select class="input-field text" name="advancing_team">
            <option value="">-- Vybrať --</option>
            <option value="{{ $game->home_team_id }}">{{ $game->homeTeam->name }}</option>
            <option value="{{ $game->away_team_id }}">{{ $game->awayTeam->name }}</option>
        </select>
    </fieldset>

    @endif

    @endif
    <fieldset class="flex flex-justify-center flex-no-gap">
        <input class="btn btn-primary" type="submit" value="Potvrdiť">
    </fieldset>
</form>