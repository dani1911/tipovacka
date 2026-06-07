<div>
    <h3 class="title-h3">{{ __('Today\'s games') }}</h3>
    <section class="games-list">
        @forelse ($games as $game)
            <x-game-box :game="$game" />
        @empty
            <p class="game-box text-center">{{ __('No games scheduled for today') }}</p>
        @endforelse
    </section>
    <h3 class="title-h3">{{ __('Top predictors') }}</h3>
    <p class="game-box text-center">{{ __('No games were played yet') }}</p>
</div>