<form action="{{ route('game.update', ['id' => $game->id]) }}" method="post">
    @csrf
    <input type="number" name="home_team_goals">
    <input type="number" name="away_team_goals">
    <input type="submit" value="Potvrdiť">
</form>