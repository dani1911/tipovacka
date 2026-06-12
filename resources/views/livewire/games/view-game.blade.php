<article>
    <header class="game-view__header my-2">
        <div class="flex items-start">
            <div class="w-full max-w-20 flex self-center justify-start">
                <img
                    src="{{ asset('storage/' . $game->homeTeam->logo) }}"
                    alt="{{ $game->homeTeam->name }} flag"
                    class="game-view__logo"
                >
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
                <img
                    src="{{ asset('storage/' . $game->awayTeam->logo) }}"
                    alt="{{ $game->awayTeam->name }} flag"
                    class="game-view__logo"
                >
            </div>
        </div>
        <div class="game-view__teams flex justify-between items-center">
            <div class="game-view__team-name text-left">{{ $game->homeTeam->name }}</div>
            <div>
                @auth
                    @if (!$game->userPrediction)
                        @if (!$game->hasDeadlinePassed())
                            <div class="">
                                <button
                                    wire:click="$dispatch('gamePredictionModal', {
                                                game_id: {{ $game->id }},
                                                action: 'create'
                                            })"
                                    class="btn flex items-center gap-1 text-sm">
                                    <x-tabler-new-section /> <span>{{ __('Add prediction') }}</span>
                                </button>
                            </div>
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
            <div class="game-view__team-name text-right">{{ $game->awayTeam->name }}</div>
        </div>
    </header>
    <h3 class="title-h3">{{ __('All predictions') }}</h3>
    <section class="game-view__prediction-list">
        @forelse ($predictions as $prediction)
            <div class="flex items-center py-1">
                <x-user-name :tournament="$tournament" :user="$prediction->user" />
                @if ($game->hasDeadlinePassed())
                    <span
                        class="inline-flex justify-center items-center w-17.5"
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
    @auth
        <livewire:predictions.manage-game-prediction />
    @endauth
</article>