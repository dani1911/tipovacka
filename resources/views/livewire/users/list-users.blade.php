<div>
    <section>
        <h3 class="title-h3">{{ __('Predictors') }}</h3>
    </section>
    <section class="user-list">
        @forelse ($users as $user)
            <div class="flex items-center py-1">
                <x-user-name :tournament="$tournament" :user="$user" />
                <span
                    class="inline-flex justify-end items-center w-17.5"
                >
                    {{ $user->total_points }}
                </span>
            </div>
        @empty
            <p class="game-box text-center">{{ __('No games were played yet') }}</p>
        @endforelse
    </section>
</div>