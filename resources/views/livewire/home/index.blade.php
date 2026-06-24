<div>
    <h3 class="title-h3">{{ __('Today\'s games') }}</h3>
    <section class="games-list">
        @forelse ($games as $game)
            <x-game-box :game="$game" />
        @empty
            <p class="game-box text-center">{{ __('No games scheduled for today') }}</p>
        @endforelse
    </section>
    <section class="flex justify-between items-center">
        <h3 class="title-h3">{{ __('Top predictors') }}</h3>
        <section class="button-container flex justify-end">
            <button
                wire:click="$set('activeStage', 'group')"
                @class([
                    'btn',
                    'muted' => $activeStage !== 'group'
                ])
            >
                {{ __('Group stage') }}
            </button>
            <button
                wire:click="$set('activeStage', 'knockout')"
                @class([
                    'btn',
                    'muted' => $activeStage !== 'knockout'
                ])
            >
                {{ __('Knockout stage') }}
            </button>
        </section>
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
    <livewire:predictions.manage-game-prediction />
</div>