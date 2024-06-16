@extends('app')

@section('title', '| Prihlásenie')

@section('content')

    <article class="box size-xs flex flex-align-center flex-justify-center user-form">
        <form action="{{ route('login') }}" class="box flex flex-column flex-align-center" method="POST" enctype="multipart/form-data">
    
            {{ csrf_field() }}
    
            <fieldset class="flex flex-align-stretch flex-no-gap">
                <label class="flex flex-justify-center flex-align-i-center" for="email"><i class="fa-solid fa-at"></i></label>
                <input type="email" name="email" placeholder="E-mail" class="input-field @error('email') input-error @enderror">
                @error('email') <span class="error flex flex-align-i-center"></span> @enderror
            </fieldset>
            <fieldset class="flex flex-align-stretch flex-no-gap">
                <label class="flex flex-justify-center flex-align-i-center" for="password"><i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password" placeholder="Heslo" class="input-field @error('password') input-error @enderror">
                @error('password') <span class="error flex flex-align-i-center"></span> @enderror
            </fieldset>
            <fieldset class="flex flex-align-i-center flex-justify-center">
{{--                <a href="{{ route('register') }}" class="link-simple">Vytvoriť konto</a> --}}
                <input type="submit" value="Prihlásiť sa" class="btn btn-secondary">
            </fieldset>
        </form>
    </article>

@endsection