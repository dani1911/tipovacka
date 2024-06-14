<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EURO 2024 tipovačka @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=roboto:300,500,700&display=swap" rel="stylesheet" />
        <link href="/assets/fontawesome/css/fontawesome.min.css" rel="stylesheet" />
        <link href="/assets/fontawesome/css/solid.min.css" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
    </head>
    <body>
        <div class="modal">

            @if($errors->any())

            {!! implode('', $errors->all('<p>:message</p>')) !!}

            @endif

        </div>
        <header>
            <section class="content flex head">
                <img class="logo-main" src="/logo-lan.png" alt="logo">
                <h1 class="title text-center">Karpatskej tipovačka o EURO 2024</h1>

                @if (Auth::check())

                <div class="flex flex-no-wrap flex-align-center flex-no-gap">
                    <form action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-secondary" title="Odhlásiť sa">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

                @endif

            </section>
        </header>
        <main>
            <nav>
                <a href="{{ route('home') }}" class="">Domov</a>
                <a href="{{ route('standings') }}" class="">Tabuľka</a>
                <a href="{{ route('games') }}" class="">Zápasy</a>
            </nav>
            <section class="content main">
                <div class="overlay hide">
                    <span class="loader"></span>
                </div>

                @yield('content')

            </section>
        </main>
        <footer>
            <section class="content foot">
                <p>&copy; dani9 2024</p>
            </section>
        </footer>
    </body>
</html>
