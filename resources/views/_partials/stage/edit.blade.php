@extends('app')

@section('title', ' | Zadať víťazov')

@section('content')

<form action="{{ route('stage.store') }}" method="post" class="box flex flex-column flex-align-i-center size-xs">
    <h2>Aktualizovať víťazov</h2>
    @csrf
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_a"><i class="fa-solid fa-a"></i></label>
        <select class="input-field" name="group_a">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_b"><i class="fa-solid fa-b"></i></label>
        <select class="input-field" name="group_b">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_c"><i class="fa-solid fa-c"></i></label>
        <select class="input-field" name="group_c">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_d"><i class="fa-solid fa-d"></i></label>
        <select class="input-field" name="group_d">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_e"><i class="fa-solid fa-e"></i></label>
        <select class="input-field" name="group_e">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="group_f"><i class="fa-solid fa-f"></i></label>
        <select class="input-field" name="group_f">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="final"><i class="fa-solid fa-trophy"></i></label>
        <select class="input-field" name="final">
            <option value="">-- Vybrať --</option>
            @foreach ($teams as $team)

            <option value="{{ $team->id }}">{{ $team->name }}</option>
                
            @endforeach
        </select>
    </fieldset>
    <fieldset class="flex flex-align-stretch flex-no-gap">
        <input class="btn btn-primary" type="submit" value="Potvrdiť">
    </fieldset>
</form>

@endsection