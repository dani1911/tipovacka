<x-filament-panels::page>
    TODO this will display knockout tree with interactive game advancement management<br>
    0. do not render unused stages - or lets do a pivot table to get available stages for tournament<br>
    1. click will activate the game box with winner and loser options + store source_game_id in livewire<br>
    2. selecting an option will store the option value in livewire<br>
    3. selecting another gamebox (next round only restriction) will activate the gamebox with options home/away + store destination_game_id in livewire<br>
    4. selecting an option will store the value to livewire + if all 4 are set will activate a confirmation button<br>
    5. clicking confirmation button will save the data to game_advancements db table<br>
    6. linked games should be visually connected<br>

    <div class="wrapper">
        @foreach ($stages as $stage)
{{-- TODO do not render unused stages --}}
        <div class="column">

            @foreach ($games->where('stage_id', $stage->id) as $game)

            <x-filament::section>
                <x-slot name="heading">
                    {{ $game->game_number }}
                </x-slot>

                <x-slot name="description">
                    {{ $game->game_time->format("d. m. Y H:i") }}
                </x-slot>

            </x-filament::section>
                
            @endforeach

        </div>

        @endforeach
    </div>

</x-filament-panels::page>
