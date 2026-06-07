<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  data-theme="{{ $tournament->slug ?? '' }}">
    <head>
        @include('layouts._partials.head')
    </head>
    <body>
        @include('layouts._partials.header')

        @include('layouts._partials.nav')

        <main class="main-content">
            <section class="content">

                @yield('content')

            </section>

        </main>

        @include('layouts._partials.footer')

        @livewireScripts
        @fluxScripts
        <x-flash-toast />
    </body>
</html>
