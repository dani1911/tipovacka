<article>
    <header class="game-view__header my-2">
        <div class="flex items-start">
            <div class="w-full max-w-20 flex self-center justify-start">
                @if (isset($game->homeTeam))
                    <img
                        src="{{ asset('storage/' . $game->homeTeam->logo) }}"
                        alt="{{ $game->homeTeam->name }} flag"
                        class="game-view__logo"
                    >
                @else
                    <div class="game-view__placeholder-logo muted">
                        <x-tabler-shield-half-f class="w-20 h-20" />
                    </div>
                @endif
            </div>
            <div class="flex-1 flex flex-col items-center justify-center">
                <div class="game-view__meta flex gap-1 flex-wrap justify-center">
                    <span class="badge">{{ $game->game_time->format('d. m. Y H:i') }}</span>
                    <span class="badge">{{ $game->stage->name }}</span>
                </div>
                <div class="game-view__score">
                    @if ($game->hasScore)
                        <span class="badge">{{ $game->home_team_score }}</span>
                        <span>:</span>
                        <span class="badge">{{ $game->away_team_score }}</span>
                    @endif
                </div>
            </div>
            <div class="w-full max-w-20 flex self-center justify-end">
                @if (isset($game->awayTeam))
                    <img
                        src="{{ asset('storage/' . $game->awayTeam->logo) }}"
                        alt="{{ $game->awayTeam->name }} flag"
                        class="game-view__logo"
                    >
                @else
                    <div class="game-view__placeholder-logo muted">
                        <x-tabler-shield-half-f class="w-20 h-20" />
                    </div>
                @endif
            </div>
        </div>
        <div class="game-view__teams flex justify-between items-center">
            <div class="game-view__team-name text-left">{{ $game->homeTeam?->name }}</div>
            <div>
                @auth
                    @if (!$game->userPrediction)
                        @if (!$game->hasDeadlinePassed() && $game->stage->phase === 'group')
                            <button
                                wire:click="$dispatch('gamePredictionModal', {
                                            game_id: {{ $game->id }},
                                            action: 'create'
                                        })"
                                class="btn flex items-center gap-1 text-sm whitespace-nowrap">
                                <x-tabler-new-section /> <span>{{ __('Add prediction') }}</span>
                            </button>
                        @endif
                    @else
                        <div
                            @class([
                                'game-view__prediction badge',
                                'correct' => $game->hasScore && $game->userPrediction?->isCorrect,
                                'incorrect' => $game->hasScore && !$game->userPrediction?->isCorrect,
                            ])
                            @if (!$game->hasDeadlinePassed())
                                wire:click="$dispatch('gamePredictionModal', {
                                            game_id: {{ $game->id }},
                                            action: 'edit'
                                        })"
                            @endif
                        >
                            {{ __('My prediction') }} {{ $game->userPrediction?->home_team_score }}:{{ $game->userPrediction?->away_team_score }}
                        </div>
                    @endif
                @endauth
            </div>
            <div
                class="game-view__team-name text-right">{{ $game->awayTeam?->name}}</div>
        </div>
    </header>
    @if ($game->stage->isKnockout())
        @if($validPredictions->isNotEmpty())
            <h3 class="title-h3">{{ __('Predictions') }}</h3>
            <section class="game-view__prediction-list">
                @foreach ($validPredictions as $prediction)
                    <div class="flex items-center py-1">
                        <x-user-name :tournament="$tournament" :user="$prediction->user" />
                            @if ((!$game->homeTeam || !$game->awayTeam) && null !== $prediction->homeTeam && null !== $prediction->awayTeam)
                                <span class="inline-flex justify-center items-center">
                                    <img
                                        src="{{ asset('storage/' . $prediction->homeTeam->image) }}"
                                        alt="{{ $prediction->homeTeam->name }} flag"
                                        class="game-view__flag mr-2"
                                    >
                                    vs
                                    <img
                                        src="{{ asset('storage/' . $prediction->awayTeam->image) }}"
                                        alt="{{ $prediction->awayTeam->name }} flag"
                                        class="game-view__flag ml-2"
                                    >
                                </span>
                            @endif
                        @if ($game->hasDeadlinePassed())
                            <span class="inline-flex justify-center items-center w-17.5">
                                <span
                                    @class([
                                        'badge' => $prediction->isCorrect
                                    ])
                                >
                                    {{ $prediction->home_team_score }} : {{ $prediction->away_team_score }}
                                </span>
                            </span>
                            @if (null !== $prediction->winnerTeam)
                                <div class="inline-flex justify-center items-center gap-2 w-17.5">
                                    <img
                                        src="{{ asset('storage/' . $prediction->winnerTeam->image) }}"
                                        alt="{{ $prediction->winnerTeam->name }}"
                                        class="game-view__flag"
                                    >
                                    <div>
                                        @if ($game->hasScore && $prediction->winnerTeam?->id === $game->winnerTeam?->id)
                                            <x-heroicon-c-check-circle class="w-6 h-6 is-correct" />
                                        @elseif ($game->hasScore)
                                            <x-heroicon-c-x-circle class="w-6 h-6 is-incorrect" />
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @else
                            <span class="w-9 ml-3 text-center">? : ?</span>
                        @endif
                    </div>
                @endforeach
            </section>
        @endif
        @if($invalidPredictions->isNotEmpty())
            <h3 class="title-h3 muted">{{ __('Invalid predictions') }}</h3>
            <section class="game-view__prediction-list muted">
                @foreach ($invalidPredictions as $prediction)
                    <div class="flex items-center py-1">
                        <x-user-name :tournament="$tournament" :user="$prediction->user" />
                        @if (null !== $prediction->homeTeam && null !== $prediction->awayTeam)
                            <span class="inline-flex justify-center items-center mr-2">
                                <img
                                    src="{{ asset('storage/' . $prediction->homeTeam->image) }}"
                                    alt="{{ $prediction->homeTeam->name }} flag"
                                    class="game-view__flag mr-2"
                                >
                                vs
                                <img
                                    src="{{ asset('storage/' . $prediction->awayTeam->image) }}"
                                    alt="{{ $prediction->awayTeam->name }} flag"
                                    class="game-view__flag ml-2"
                                >
                                <span class="w-9 ml-3 text-center">
                                    {{ $prediction->home_team_score }} : {{ $prediction->away_team_score }}
                                </span>
                            </span>
                            @if (null !== $prediction->winnerTeam)
                                <div class="inline-flex justify-center items-center gap-2 w-17.5">
                                    <img
                                        src="{{ asset('storage/' . $prediction->winnerTeam->image) }}"
                                        alt="{{ $prediction->winnerTeam->name }}"
                                        class="game-view__flag"
                                    >
                                    <div>
                                        @if ($game->hasScore && $prediction->winnerTeam?->id === $game->winnerTeam?->id)
                                            <x-heroicon-c-check-circle class="w-6 h-6 is-correct" />
                                        @elseif ($game->hasScore)
                                            <x-heroicon-c-x-circle class="w-6 h-6 is-incorrect" />
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                @endforeach
            </section>
        @endif
        @if($validPredictions->isEmpty() && $invalidPredictions->isEmpty())
            <p class="game-box text-center">{{ __('No predictions yet') }}</p>
        @endif
    @else
        <h3 class="title-h3">{{ __('All predictions') }}</h3>
        <section class="game-view__prediction-list">
            @forelse ($predictions as $prediction)
                <div class="flex items-center py-1">
                    <x-user-name :tournament="$tournament" :user="$prediction->user" />
                    @if ($game->stage->isKnockout())
                        @if (null !== $prediction->homeTeam && null !== $prediction->awayTeam)
                            <span class="inline-flex justify-center items-center">
                                <img
                                    src="{{ asset('storage/' . $prediction->homeTeam->image) }}"
                                    alt="{{ $prediction->homeTeam->name }}"
                                    class="game-view__flag mr-2"
                                >
                                vs
                                <img
                                    src="{{ asset('storage/' . $prediction->awayTeam->image) }}"
                                    alt="{{ $prediction->awayTeam->name }}"
                                    class="game-view__flag ml-2"
                                >
                            </span>
                        @endif
                    @endif
                    @if ($game->hasDeadlinePassed())
                        <span
                            class="inline-flex justify-center items-center w-17.5 ml-3"
                        >
                            <span
                                @class([
                                    'badge' => $prediction->isCorrect
                                ])
                            >
                                {{ $prediction->home_team_score }} : {{ $prediction->away_team_score }}
                            </span>
                        </span>
                    @else
                        <span>? : ?</span>
                    @endif
                </div>
            @empty
                <p class="game-box text-center">{{ __('No predictions yet') }}</p>
            @endforelse
        </section>
    @endif

    @auth
        <livewire:predictions.manage-game-prediction />
    @endauth
</article>