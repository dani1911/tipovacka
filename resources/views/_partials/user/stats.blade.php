@if ($user->name == 'none')

<div class="user-title size-xs flex flex-justify-space-around" data-user="{{ $user->id }}">
    <h2>Žiadne tipy</h2>
</div>

@else
    
<div class="user-title size-xs flex flex-justify-space-around" data-user="{{ $user->id }}">
    <h2>{{ $user->name }}</h2><span class="badge success">{{ $user->points }}</span>
</div>

@if ($stage_predictions->stagePredictions->isNotEmpty())

<div class="box size-xs user-stage-predictions">

    <h3>Tipy na víťazov</h3>
    <table>
        <tr>
            <th class="stage">Fáza</th>
            <th>Tip</th>
            <th></th>
        </tr>
    
            
    @foreach ($stage_predictions->stagePredictions as $stage)

        <tr>
            <td class="stage">{{ $stage->stage->name }}</td>
            <td>{{ $stage->team->name }}</td>
            <td>
                @if ($stage->points === 1)
                <i class="fa-solid fa-circle-check"></i>
                @elseif ($stage->points === 0)
                <i class="fa-solid fa-circle-xmark"></i>
                @endif
            </td>
        </tr>
        
    @endforeach

    </table>
    <div class="vertical-scroll-table">
        <div class="inner-scroll">
        </div>
    </div>
</div>

@endif
    
<div class="box size-xs">
    <h3>Tipy na zápasy</h3>
    <table class="games-table">
        <tr>
            <th>Zápas</th>
            <th>Tip</th>
        </tr>
    @foreach ($game_predictions as $prediction)

        @php
            $isSuccess = $isFail = false;
            if ($prediction->gphg === $prediction->ghg && $prediction->gpag === $prediction->gag) $isSuccess = true;
        @endphp

           
        <tr>
            <td>
                <a href="{{ route('game', $prediction->gpgid) }}">
                    <div class="date">{{ \Carbon\Carbon::parse($prediction->game_date)->format($date_format) }}</div>
                    <div class="game flex flex-column">
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $prediction->htabb }}.png" class="team-flag" alt="{{ $prediction->htname }}"> {{ $prediction->htname }}</span>
                            <span>{{ $prediction->ghg }}</span>
                        </div>
                        <div class="team flex flex-align-c-center flex-justify-space-between">
                            <span class="flex flex-align-c-center"><img src="/img/teams/{{ $prediction->atabb }}.png" class="team-flag" alt="{{ $prediction->atabb }}"> {{ $prediction->atname }}</span>
                            <span>{{ $prediction->gag }}</span>
                        </div>
                    </div>
                </a>
            </td>
            <td class="prediction text-center">
                <span @class(['badge', 'success' => $isSuccess, 'fail' => $isFail])>{{ $prediction->gphg }} : {{ $prediction->gpag }}</span>
            </td>
        </tr>

    @endforeach
    
    </table>
</div>

@endif