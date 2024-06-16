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
                    <th>Skupina A</th>
                    <th>Skupina B</th>
                    <th>Skupina C</th>
                    <th>Skupina D</th>
                    <th>Skupina E</th>
                    <th>Skupina F</th>
                    <th>EURO</th>
                </tr>
        
            @foreach ($users as $user)
        
            <tr>
                <td class="table-col-fixed table-col-border">
                    <a href="{{ route('user', $user->id) }}">{{ $user->name }}</a>
                </td>
        
                @php
                    $stage = 1;
                @endphp
                @foreach ($user->stagePredictions as $prediction)
                @php
                    $isWinner = false;
                    if ($prediction->points === 1) $isWinner = true;
                @endphp
        
                <td>
        
                    @if ($stage == $prediction->stage)
                
                    <span @class(['winner' => $isWinner])>{{ $prediction->team->name ?? '' }}</span>
        
                    @endif
        
                </td>
                    
                @php
                    $stage++;
                @endphp
                @endforeach
                
            </tr>
                
            @endforeach
            @if ($stage_winners->isNotEmpty())
                
            <tr>
                <td class="table-col-fixed table-col-border"><span class="bold">Víťazi</span></td>
    
                @foreach ($stage_winners as $winner)
                    
                <td><span class="bold">{{ $winner->team->name }}</span></td>
    
                @endforeach
    
            </tr>
    
            @endif
            
            </table>
        </div>
    </div>
</div>

@endsection