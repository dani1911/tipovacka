<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EURO 2024 tipovačka @yield('title')</title>

        @vite(['resources/css/app.css', 'resources/css/fontawesome/css/fontawesome.min.css', 'resources/css/fontawesome/css/solid.min.css', 'resources/js/app.js'])
        
    </head>
    <body>
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

                @if (Auth::check() && Auth::user()->id === 1)

                <a href="{{ route('stage.edit') }}" class=""><i class="fa-solid fa-pen-to-square"></i> <span class="desktop">Upraviť víťazov</span></a>

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
