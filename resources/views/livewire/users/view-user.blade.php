<div>
    <section class="page-heading flex justify-between items-center">
        <h3 class="text-4xl font-bold">{{ $user->name }}</h3>
        <div class="badge text-3xl flex justify-center items-center">{{ $totalPoints }}</div>
    </section>
    <section class="games-list">
        @forelse ($groupGames as $game)
            <x-game-box :game="$game" />
        @empty
            <p>{{ __('No games added yet') }}</p>
        @endforelse
    </section>
    @auth
        <livewire:predictions.manage-game-prediction />
    @endauth
</div>