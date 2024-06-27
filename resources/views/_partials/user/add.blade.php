@extends('app')

@section('title', ' | Pridať zápas')

@section('content')

<form action="{{ route('user.create') }}" method="post" class="box size-xs">
    <h2>Nový tipér</h2>
    @csrf
    <fieldset class="flex flex-justify-center flex-no-gap">
        <label class="flex flex-justify-center flex-align-i-center" for="user_name"><i class="fa-solid fa-user"></i></label>
        <input class="input-field text" type="text" name="user_name">
    </fieldset>
    <fieldset class="flex flex-justify-center flex-no-gap">
        <input class="btn btn-primary" type="submit" value="Pridať">
    </fieldset>
</form>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@endsection