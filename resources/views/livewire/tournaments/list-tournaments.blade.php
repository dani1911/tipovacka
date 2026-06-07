<div>
    <h3 class="title-h3">{{ __('Tournaments') }}</h3>
    <section class="tournaments-list p-3">
        @forelse ($tournaments as $tournament)
            <a href="{{ route('tournament.games', $tournament->slug) }}" class="flex gap-3 p-2 items-center border-b border-white/60">
                <img src="storage/{{ $tournament->logo }}" alt="{{ $tournament->name }}" class="h-12">
                <div class="flex flex-col md:flex-row md:items-center md:gap-4">
                    <span class="font-bold">{{ $tournament->name }}</span>
                    <span class="text-sm">{{ $tournament->start_date->format('d. m. Y') }} - {{ $tournament->end_date->format('d. m. Y') }}</span>
                </div>
                <flux:button icon="eye" class="ml-auto">
                    {{ __('View games') }}
                </flux:button>
            </a>
        @empty
            <p class="game-box text-center">{{ __('No tournaments found') }}</p>
        @endforelse
</div>