<div id="user-content" class="flex flex-col h-full">
    <section class="page-heading flex justify-between items-center">
        <h3 class="text-4xl font-bold">{{ $user->name }}</h3>
        <div class="badge text-3xl flex justify-center items-center">{{ $totalPoints }}</div>
    </section>
    <section class="button-container flex justify-end mb-2">
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
    @if ($activeStage === 'group')
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
            </section>
            @auth
                <livewire:predictions.manage-game-prediction />
            @endauth
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
    @else
        @if($gamesByStage->isEmpty())
            <p class="game-box text-center my-5">{{ __('User hasn\'t set up his bracket yet.') }}</p>
            @auth()
                @if (!$hasDeadlinePassed && !$hasBracket)
                    <div class="flex justify-center mb-4">
                        <button
                            wire:click="createBracket"
                            wire:loading.attr="disabled"
                            class="btn flex items-center gap-1 text-2xl"
                        >
                            <x-tabler-new-section /> <span>{{ __('Create bracket') }}</span>
                        </button>
                    </div>
                @endif
            @endauth
        @else
            <div
                x-data
                x-init="initKnockoutBracket($el.querySelector(':scope > section > *'))"
                class="knockout-bracket-container flex-1 flex flex-col"
            >
                <div class="overflow-x-auto flex-1">
                    <section class="flex gap-2 items-stretch">
                        @foreach ($gamesByStage as $stageGames)
                            <div class="knockout-bracket-stage-column flex flex-col gap-1 justify-around">
                                @foreach ($stageGames as $game)
                                    <x-game-prediction-box :gamePrediction="$game" :user="$user" :eliminatedTeamIds="$eliminatedTeamIds" />
                                @endforeach
                            </div>
                        @endforeach
                        <div class="knockout-bracket-stage-column flex flex-col gap-1 justify-around relative">
                            @if (isset($finalGame[0]))
                                <x-game-prediction-box :gamePrediction="$finalGame[0]" :user="$user" :eliminatedTeamIds="$eliminatedTeamIds" />
                            @endif
                            @if (isset($bronzeGame[0]))
                                <div class="absolute mt-[165%] left-0">
                                    <x-game-prediction-box :gamePrediction="$bronzeGame[0]" :user="$user" :eliminatedTeamIds="$eliminatedTeamIds" />
                                </div>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
            @auth
                <livewire:predictions.manage-game-prediction />
            @endauth
        @endif
    @endif
</div>