<div>
    <section>
        <h3 class="title-h3">{{ __('Predictors') }}</h3>
    </section>
    <section class="user-list">
        @forelse ($users as $user)
            <a href="{{ route('tournament.user', [$tournament, $user]) }}">
                <div class="flex items-center py-1">
                    <span class="flex-1">{{ $user->name }}</span>
                    <span
                        class="inline-flex justify-end items-center w-17.5"
                    >
                        {{ $user->total_points }}
                    </span>
                </div>
            </a>
        @empty
            <p class="game-box text-center">{{ __('No games were played yet') }}</p>
        @endforelse
    </section>
</div>