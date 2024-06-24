<form action="{{ route('game.update', ['id' => $game->id]) }}" method="post" class="box size-xs">
    @csrf
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="home_team_goals"><i class="fa-solid fa-futbol"></i></label>
        <input class="input-field number" type="number" name="home_team_goals">
        <label class="flex flex-justify-center flex-align-i-center" for="away_team_goals"><i class="fa-solid fa-minus"></i></label>
        <input class="input-field number" type="number" name="away_team_goals">
        <input class="btn btn-primary" type="submit" value="Potvrdiť">
    </fieldset>
</form>