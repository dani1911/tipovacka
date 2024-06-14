@extends('app')

@section('title', '| Registrácia')

@section('content')

    <article class="flex flex-align-center flex-justify-center user-form">
        <form action="{{ route('new_user') }}" class="box flex flex-column flex-align-center" method="POST" enctype="multipart/form-data">
    
            {{ csrf_field() }}
    
            <fieldset class="flex flex-align-stretch flex-no-gap">
                <label class="flex flex-justify-center flex-align-center" for="name"><i class="fa-solid fa-user"></i></label>
                <input type="text" name="name" placeholder="Meno" class="input-field @error('name') input-error @enderror">
                @error('name') <span class="error flex flex-align-center"></span> @enderror
            </fieldset>
            <fieldset class="flex flex-align-stretch flex-no-gap">
                <label class="flex flex-justify-center flex-align-center" for="email"><i class="fa-solid fa-at"></i></label>
                <input type="email" name="email" placeholder="E-mail" class="input-field @error('email') input-error @enderror">
                @error('email') <span class="error flex flex-align-center"></span> @enderror
            </fieldset>
            <fieldset class="flex flex-align-stretch flex-no-gap">
                <label class="flex flex-justify-center flex-align-center" for="password"><i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password" placeholder="Heslo" class="input-field @error('password') input-error @enderror">
                @error('password') <span class="error flex flex-align-center"></span> @enderror
            </fieldset>
            <fieldset class="flex flex-align-center flex-justify-center">
                <a href="{{ route('view_login') }}" class="link-simple">Prihlásiť sa</a>
                <input type="submit" value="Zaregistrovať sa" class="btn btn-main">
            </fieldset>
        </form>
    </article>

@endsection