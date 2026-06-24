<flux:modal name="game-prediction-modal" class="game-prediction-modal max-w-11/12 md:w-96">
    <div class="space-y-4">
        <div>
            <flux:heading size="lg">
                <h3 class ="game-prediction-modal__heading">{{ __('Game prediction') }}</h3>
            </flux:heading>
        </div>
        <form wire:submit="save">
            <div class="grid grid-cols-2 gap-4">
                <field class="flex flex-col justify-between items-center">
                    <label class="flex-col">
                        <div class="game-prediction__flag">
                            @if (isset($home_team_image))
                                <img src="{{ asset('storage/' . $home_team_image) }}" alt="{{ $home_team_name }}">
                            @endif
                        </div>
                        <div class="game-prediction__team-name text-center mt-1">{{ $home_team_name }}</div>
                    </label>
                    <input
                        wire:model.live="home_team_score"
                        type="number"
                        min="0"
                        step="1"
                        placeholder="0"
                        class="score-input bg-white w-full text-center"
                        autofocus
                    />
                </field>
                <field class="flex flex-col justify-between items-center">
                    <label class="flex-col">
                        <div class="game-prediction__flag">
                            @if (isset($away_team_image))
                                <img src="{{ asset('storage/' . $away_team_image) }}" alt="{{ $away_team_name }}">
                            @endif
                        </div>
                        <div class="game-prediction__team-name text-center mt-1">{{ $away_team_name }}</div>
                    </label>
                    <input
                        wire:model.live="away_team_score"
                        type="number"
                        min="0"
                        step="1"
                        placeholder="0"
                        class="score-input bg-white w-full text-center"
                    />
                </field>
            </div>
            @if($is_knockout && isset($home_team_score, $away_team_score) && $home_team_score === $away_team_score)
                <p class="text-accent pl-2 mt-2">{{ __('Advancing team') }}</p>
                <flux:select wire:model="winner_team_id">
                    <flux:select.option :value="$home_team_id">{{ $home_team_name }}</flux:select.option>
                    <flux:select.option :value="$away_team_id">{{ $away_team_name }}</flux:select.option>
                </flux:select>
            @endif
            <div class="flex w-full justify-end mt-4">
                <flux:button type="submit" variant="primary">{{ __('Save prediction') }}</flux:button>
            </div>
        </form>
    </div>
</flux:modal>