@props(['game', 'user' => auth()->user()])
<article class="game-box">
    <section class="game-box__header">
        <span class="badge">
            {{ $game->game_time->format('d. m. Y H:i') }}
        </span>
        <span class="badge">
            {{ $game->stage->name }}
        </span>
    </section>
    <section class="game-box__body">
        <a href="{{ route('tournament.game', [$game->tournament, $game]) }}" class="game-box__game">
            <div class="game-box__row">
                <div class="game-box__team">
                    <div class="game-box__flag">
                        <img src="{{ asset('storage/' . $game->homeTeam->image) }}" alt="{{ $game->homeTeam->name }}">
                    </div>
                    <span title="{{ $game->homeTeam->name }}">{{ $game->homeTeam->name }}</span>
                </div>
                @if ($game->hasScore)
                <div class="game-box__score">
                    <span class="badge">{{ $game->home_team_score }}</span>
                </div>
                @endif
                @auth
                <div @class([ 'game-box__prediction' , 'correct'=> $game->hasScore && $game->gamePredictions->firstWhere('user_id', $user?->id)?->isCorrect,
                    'incorrect' => $game->hasScore && !$game->gamePredictions->firstWhere('user_id', $user?->id)?->isCorrect,
                    ])>
                    {{ $game->gamePredictions->firstWhere('user_id', $user?->id)?->home_team_score }}
                </div>
                @endauth
            </div>
            <div class="game-box__row">
                <div class="game-box__team">
                    <div class="game-box__flag">
                        <img src="{{ asset('storage/' . $game->awayTeam->image) }}" alt="{{ $game->awayTeam->name }}">
                    </div>
                    <span title="{{ $game->awayTeam->name }}">{{ $game->awayTeam->name }}</span>
                </div>
                @if ($game->hasScore)
                    <div class="game-box__score">
                        <span class="badge">{{ $game->away_team_score }}</span>
                    </div>
                @endif
                @auth
                    <div @class([ 'game-box__prediction' , 'correct'=> $game->hasScore && $game->gamePredictions->firstWhere('user_id', $user?->id)?->isCorrect,
                        'incorrect' => $game->hasScore && !$game->gamePredictions->firstWhere('user_id', $user?->id)?->isCorrect,
                        ])>
                        {{ $game->gamePredictions->firstWhere('user_id', $user?->id)?->away_team_score }}
                    </div>
                @endauth
            </div>
        </a>
        @if ($game->hasScore)
            <div class="game-box__stats">
                <span
                    @class(["badge" => $game->correctGamePredictions > 0])
                >
                    {{ $game->correctGamePredictions }}
                </span>
            </div>
        @endif
        @auth
            @if (auth()->id() === $user->id && !$game->hasDeadlinePassed())
                @if ($game->userPrediction)
                    <div class="game-box__action">
                        <button
                            wire:click="$dispatch('gamePredictionModal', {
                                        game_id: {{ $game->id }},
                                        action: 'edit'
                                    })"
                            class="btn">
                            <x-tabler-edit />
                        </button>
                    </div>
                @else
                    <div class="game-box__action">
                        <button
                            wire:click="$dispatch('gamePredictionModal', {
                                        game_id: {{ $game->id }},
                                        action: 'create'
                                    })"
                            class="btn">
                            <x-tabler-new-section />
                        </button>
                    </div>
                @endif
            @endif
        @endauth
    </section>
</article>