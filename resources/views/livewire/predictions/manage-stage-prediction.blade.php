<flux:modal name="stage-prediction-modal" class="stage-prediction-modal max-w-11/12 md:w-6/12">
    <div class="space-y-4">
        <div>
            <flux:heading size="lg">
                <h3 class ="stage-prediction-modal__heading text-white">{{ __('Stage predictions') }}</h3>
            </flux:heading>
        </div>
        <form wire:submit="save">
            <div class="flex flex-col justify-between items-center gap-4">
                @if ($stages)
                    @foreach($stages as $stage)
                        <field class="w-full flex justify-between items-center gap-3">
                            <flux:input.group>
                                <div class="flex items-center px-4 text-sm whitespace-nowrap bg-zinc-800/5 dark:bg-white/20 border-zinc-200 dark:border-white/10 border-s border-t border-b shadow-xs text-white">{{ $stage->name }}</div>
                                <select
                                    wire:model="predictions.{{ $stage->id }}"
                                    class="bg-white w-full p-2"
                                >
                                    <option value="null">{{ __('Select team') }}</option>
                                    @foreach ($stageTeams->where('stage_id', $stage->id) as $team)
                                        <option value="{{ $team->team->id }}">{{ $team->team->name }}</option>
                                    @endforeach
                                </select>
                            </flux:input.group>
                        </field>
                    @endforeach
                @endif
            </div>
            <div class="flex w-full justify-end mt-4">
                <flux:button type="submit" variant="primary">{{ __('Save predictions') }}</flux:button>
            </div>
        </form>
    </div>
</flux:modal>