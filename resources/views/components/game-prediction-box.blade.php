@props([
    'gamePrediction',
    'eliminatedTeamIds' => [],
    'user',
])
<article 
    @class([
        "game-box",
        "muted" => !$gamePrediction->areTeamsCorrect && (in_array($gamePrediction->home_team_id, $eliminatedTeamIds) || in_array($gamePrediction->away_team_id, $eliminatedTeamIds))
    ])
>
    <section class="game-box__header">
        <span class="badge">
            {{ $gamePrediction->game->game_time->format('d. m. Y H:i') }}
        </span>
        <span class="badge">
            {{ __('GM') }}{{ $gamePrediction->game->game_number }}
        </span>
    </section>
    <section class="game-box__body">
        <a href="{{ route('tournament.game', [$gamePrediction->game->tournament, $gamePrediction->game]) }}" class="game-box__game">
            <div class="game-box__row">
                <div class="game-box__team">
                    @if (isset($gamePrediction->homeTeam))
                        <div class="game-box__flag">
                            <img src="{{ asset('storage/' . $gamePrediction->homeTeam->image) }}" alt="{{ $gamePrediction->homeTeam->name }}">
                        </div>
                        <span title="{{ $gamePrediction->homeTeam->name }}">{{ $gamePrediction->homeTeam->name }}</span>
                    @else
                        <div class="game-box__flag bg-gray-100 text-gray-500">
                            <x-tabler-question-mark />
                        </div>
                        <span>TBD</span>
                    @endif
                </div>
                @if ($gamePrediction->game->hasScore)
                <div class="game-box__score">
                    <span class="badge">{{ $gamePrediction->game->home_team_score }}</span>
                </div>
                @endif
                @auth
                <div @class([ 'game-box__prediction' , 'correct'=> $gamePrediction->game->hasScore && $gamePrediction?->isCorrect,
                    'incorrect' => $gamePrediction->game->hasScore && !$gamePrediction?->isCorrect,
                    ])>
                    {{ $gamePrediction?->home_team_score }}
                </div>
                @endauth
            </div>
            <div class="game-box__row">
                <div class="game-box__team">
                    @if (isset($gamePrediction->awayTeam))
                        <div class="game-box__flag">
                            <img src="{{ asset('storage/' . $gamePrediction->awayTeam->image) }}" alt="{{ $gamePrediction->awayTeam->name }}">
                        </div>
                        <span title="{{ $gamePrediction->awayTeam->name }}">{{ $gamePrediction->awayTeam->name }}</span>
                    @else
                        <div class="game-box__flag bg-gray-100 text-gray-500">
                            <x-tabler-question-mark />
                        </div>
                        <span>TBD</span>
                    @endif
                </div>
                @if ($gamePrediction->game->hasScore)
                    <div class="game-box__score">
                        <span class="badge">{{ $gamePrediction->game->away_team_score }}</span>
                    </div>
                @endif
                @auth
                    <div @class([ 'game-box__prediction' , 'correct'=> $gamePrediction->game->hasScore && $gamePrediction?->isCorrect,
                        'incorrect' => $gamePrediction->game->hasScore && !$gamePrediction?->isCorrect,
                        ])>
                        {{ $gamePrediction?->away_team_score }}
                    </div>
                @endauth
            </div>
        </a>
        {{-- @if ($gamePrediction->game->hasScore)
            <div class="game-box__stats">
                <span
                    @class(["badge" => $gamePrediction->game->correctGamePredictions > 0])
                >
                    {{ $gamePrediction->game->correctGamePredictions }}
                </span>
            </div>
        @endif --}}
        @auth
            @if (auth()->id() === $user->id && !$gamePrediction->game->hasDeadlinePassed())
                <div class="game-box__action">
                    <button
                        wire:click="$dispatch('gamePredictionModal', {
                                    game_id: {{ $gamePrediction->game->id }},
                                    action: 'edit'
                                })"
                    >
                        <x-tabler-edit />
                    </button>
                </div>
            @endif
        @endauth
    </section>
</article>