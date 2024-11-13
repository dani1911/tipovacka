<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EURO 2024 tipovačka @yield('title')</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('/css/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/fontawesome/css/solid.min.css') }}">

        {{-- dev --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body data-page="{{ Route::current()->getName() }}">
        <div class="modal">

            @if($errors->any())

            {!! implode('', $errors->all('<p>:message</p>')) !!}

            @endif

        </div>
        <header>
            <section class="content flex flex-justify-space-around flex-align-i-center">
                <img class="logo-main" src="/img/logo-por.png" alt="logo">
                <h1 class="title text-center">Karpatská tipovačka</h1>

                @if (Auth::check() && Auth::user()->id === 1)

                <div class="flex flex-no-wrap flex-align-center flex-no-gap">
                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary" title="Odhlásiť sa">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

                @endif

            </section>
            <nav class="main-navigation">
                <a href="{{ route('home') }}" class=""><i class="fa-solid fa-house"></i> <span class="desktop">Domov</span></a>
                <a href="{{ route('standings') }}" class=""><i class="fa-solid fa-list"></i> <span class="desktop">Tabuľka</span></a>
                <a href="{{ route('games') }}" class=""><i class="fa-solid fa-futbol"></i> <span class="desktop">Zápasy</span></a>
                <a href="{{ route('stage') }}" class=""><i class="fa-solid fa-star"></i> <span class="desktop">Víťazi</span></a>
                <a href="{{ route('playoffs') }}" class=""><i class="fa-solid fa-sitemap"></i> <span class="desktop">Playoffs</span></a>

                @if (Auth::check() && Auth::user()->id === 1)

                <a href="{{ route('stage.edit') }}" class=""><i class="fa-solid fa-pen-to-square"></i> <span class="desktop">Upraviť víťazov</span></a>
                <a href="{{ route('user.add') }}" class=""><i class="fa-solid fa-plus fa-2xs"></i> <i class="fa-solid fa-user"></i> <span class="desktop">Pridať tipéra</span></a>
                <a href="{{ route('game.add') }}" class=""><i class="fa-solid fa-plus fa-2xs"></i> <i class="fa-solid fa-futbol"></i> <span class="desktop">Pridať zápas</span></a>
                <a href="{{ route('prediction.add') }}" class=""><i class="fa-solid fa-plus fa-2xs"></i> <i class="fa-solid fa-circle-question"></i> <span class="desktop">Pridať tip</span></a>

                @endif
            </nav>
        </header>
        <main>
            <section class="content flex flex-column flex-align-i-center">
                <div class="overlay hide">
                    <span class="loader"></span>
                </div>

                @yield('content')

            </section>
        </main>
        <footer>
            <section class="content text-center">
                <a href="mailto:dani.strba@gmail.com">&copy; dani9 2024</a>
            </section>
        </footer>
    </body>
</html>
