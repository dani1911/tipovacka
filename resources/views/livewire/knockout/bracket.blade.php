<div class="flex flex-col h-full">
    <h3 class="title-h3">{{ __('Knockout bracket') }}</h3>
    <div class="knockout-bracket-container flex-1 flex flex-col">
        <div class="overflow-x-auto flex-1">
            <section class="flex gap-2 items-stretch">
                @foreach ($gamesByStage as $stageGames)
                    <div class="knockout-bracket-stage-column flex flex-col gap-1 justify-around">
                        @foreach ($stageGames as $game)
                            <x-game-box :game="$game" :showButtons="false" />
                        @endforeach
                    </div>
                @endforeach
                <div class="knockout-bracket-stage-column flex flex-col gap-1 justify-around relative">
                    @if (isset($finalGame[0]))
                        <x-game-box :game="$finalGame[0]" :showButtons="false" />
                    @endif
                    @if (isset($bronzeGame[0]))
                        <div class="absolute mt-[165%] left-0">
                            <x-game-box :game="$bronzeGame[0]" :showButtons="false" />
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
    @auth
        <livewire:predictions.manage-game-prediction />
    @endauth
</div>
