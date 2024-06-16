<form action="{{ route('game.update', ['id' => $game->id]) }}" method="post" class="box">
    @csrf
    <input class="input-field number" type="number" name="home_team_goals">
    <input class="input-field number" type="number" name="away_team_goals">
    <input class="btn btn-primary" type="submit" value="Potvrdiť">
</form>