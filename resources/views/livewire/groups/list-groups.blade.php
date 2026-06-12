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
    <div
        class="groups-list relative overflow-x-auto p-0 scroll-shadows"
        x-data
        x-init="
            const check = () => $el.classList.toggle('is-overflowing', $el.scrollWidth > $el.clientWidth);
            check();
            new ResizeObserver(check).observe($el);"
    >
        <table class="w-full table-fixed border-separate border-spacing-0 isolate whitespace-nowrap [&_dialog]:whitespace-normal [&_[popover]]:whitespace-normal">
            <thead>
                <tr>
                    <th class="table-col-fixed w-40 left-0 py-3 px-3 text-left">{{ __('Username') }}</th>
                    @foreach ($stages as $stage)
                        <th class="w-40 py-3 px-3 text-left">{{ $stage->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="table-col-fixed left-0 py-3 px-3">
                        <x-user-name :tournament="$tournament" :user="$user" />
                    </td>
                    @foreach ($stages as $stage)
                        <td class="py-3 px-3 overflow-hidden text-ellipsis">
                            <span
                                @class([
                                    'badge' => $user->stagePredictions->get($stage->id)?->isCorrect
                                ])
                            >
                                {{ $user->stagePredictions->get($stage->id)?->team?->name ?? '' }}
                            </span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="table-col-fixed left-0 py-3 px-3 text-left">{{ __('Winners') }}</th>
                    @foreach ($stages as $stage)
                        <th class="py-3 px-3 text-left overflow-hidden text-ellipsis">{{ $stage->stageWinner?->team?->name }}</th>
                    @endforeach
                </tr>
            </tfoot>
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