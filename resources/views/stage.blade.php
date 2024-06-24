@extends('app')

@section('title', ' | Víťazi')

@section('content')

<h2>Víťazi skupín a EURA</h2>

<div class="box">
    <div class="vertical-scroll-table">
        <div class="inner-scroll">
            <table>
                <tr>
                    <th class="table-col-fixed table-col-border">meno</th>

                    @foreach ($stages as $stage)
    
                    <th>{{ $stage->name }}</th>

                    @endforeach

                </tr>
        
            @foreach ($users as $user)
        
            <tr>
                <td class="table-col-fixed table-col-border">
                    <a href="{{ route('user', $user->id) }}">{{ $user->name }}</a>
                </td>
        

                @foreach ($stages as $stage)
                
                    <td>

                    @foreach ($user->stagePredictions as $prediction)
                    @php
                        $isWinner = false;
                        if ($prediction->points === 1) $isWinner = true;
                    @endphp
            
            
                        @if ($stage->id === $prediction->stage_id)
                    
                        <span @class(['winner' => $isWinner])>{{ $prediction->team->name ?? '' }}</span>
            
                        @endif
            
                    @endforeach
                        
                    </td>

                @endforeach
                
            </tr>
                
            @endforeach

            @if ($stage_winners->isNotEmpty())
                
            <tr>
                <td class="table-col-fixed table-col-border"><span class="bold">Víťazi</span></td>
    

                @foreach ($stages as $stage)

                <td>
                    
                    @foreach ($stage_winners as $winner)

                    @if ($stage->id === $winner->stage_id)

                    <span class="bold">{{ $winner->team->name ?? '' }}</span>

                    @endif

                    @endforeach

                </td>
    
                @endforeach
    
            </tr>
    
            @endif
            
            </table>
        </div>
    </div>
</div>

@endsection