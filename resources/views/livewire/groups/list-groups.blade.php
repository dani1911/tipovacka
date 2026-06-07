<div>
    <div>
        <h3 class="title-h3">{{ __('Group & tournament winners') }}</h3>
    </div>
    @auth
        @if (!$hasDeadlinePassed)
            <div class="flex justify-center mb-4">
                <button
                    wire:click="$dispatch('stagePredictionModal', {
                                action: 'create',
                                tournament_id: {{ $tournamentId }}
                            })"
                    class="btn flex items-center gap-1 text-2xl">
                    @if (!$userHasPredictions)
                        <x-tabler-new-section /> <span>{{ __('Add predictions') }}</span>
                    @else
                        <x-tabler-edit /> <span>{{ __('Update predictions') }}</span>
                    @endif
                </button>
            </div>
        @endif
    @endauth

    <div class="groups-list relative overflow-x-auto p-0 scroll-shadows">
        <table class="[:where(&)]:min-w-full table-fixed border-separate border-spacing-0 isolate whitespace-nowrap [&_dialog]:whitespace-normal [&_[popover]]:whitespace-normal">
            <thead>
                <tr>
                    <th class="table-col-fixed left-0 py-3 px-3">{{ __('Username') }}</th>
                    @foreach ($stages as $stage)
                        <th class="py-3 px-3">{{ $stage->name }}</th>
                    @endforeach
                    <th class="py-3 px-3">{{ __('Champion') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="table-col-fixed left-0 py-3 px-3">{{ $user->name }}</td>
                    @foreach ($stages as $stage)
                        <td class="py-3 px-3">{{ $user->stagePredictions->get($stage->id)?->team?->name ?? '' }}</td>
                    @endforeach
                    <td class="py-3 px-3">{{ $user->stagePredictions->get($finalStageId)?->team?->name ?? '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @auth
        <livewire:predictions.manage-stage-prediction wire:key="manage-stage-prediction" />
    @endauth
</div>
{{-- TODO test saving and updating predictions --}}
{{-- TODO hide predictions unless user created his own - show only add predictions button --}}
{{-- TODO show edit button over/under the table until deadline --}}
{{-- TODO implement calculated container query for the fixed column table switching --}}
{{-- TODO implement validation and error handling --}}