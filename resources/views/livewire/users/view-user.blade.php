<div>
    <section class="page-heading flex justify-between items-center">
        <h3 class="text-4xl font-bold">{{ $user->name }}</h3>
        <div class="badge text-3xl flex justify-center items-center">{{ $totalPoints }}</div>
    </section>
    <section class="tabs flex justify-center items-stretch">
        <div
            wire:click="$set('activeTab', 'games')"
            @class([
                'tab flex items-center justify-center cursor-pointer',
                'muted' => $activeTab !== 'games'
            ])
        >
            {{ __('Games') }}
        </div>
        <div
            wire:click="$set('activeTab', 'stages')"
            @class([
                'tab flex items-center justify-center cursor-pointer',
                'muted' => $activeTab !== 'stages'
            ])
        >
            {{ __('Group winners') }}
        </div>
    </section>
    @if ($activeTab === 'games')
        <section class="games-list">
            @forelse ($groupGames as $game)
                <x-game-box :game="$game" :user="$user"/>
            @empty
                <p class="game-box text-center">{{ __('No games added yet') }}</p>
            @endforelse
            @auth
                <livewire:predictions.manage-game-prediction />
            @endauth
        </section>
    @else
        <section class="stage-winners">
            <table class="w-full">
                <tbody>
                    @forelse ($stagePredictions as $prediction)
                        <tr>
                            <td class="p-2 uppercase">
                                {{ $prediction->stage->name }}
                            </td>
                            <td class="p-2 uppercase">
                                {{ $prediction->team->name }}
                            </td>
                            <td class="p-1">
                                @php $status = $prediction->predictionStatus() @endphp
                                @switch($status)
                                    @case('correct')
                                        <x-heroicon-c-check-circle class="w-6 h-6 is-correct" />
                                        @break
                                
                                    @case('incorrect')
                                        <x-heroicon-c-x-circle class="w-6 h-6 is-incorrect" />
                                        @break
                                
                                    @default
                                        
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                {{ __('No stage predictions added yet') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    @endif
</div>