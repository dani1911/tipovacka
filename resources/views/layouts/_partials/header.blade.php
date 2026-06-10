<header class="page-header">
    <section class="content">
        @if (isset($tournament->logo))
            <img src="{{ asset('storage/' . $tournament->logo) }}" alt="{{ $tournament->name }} logo">
        @else
            <img src="{{ asset('storage/img/karpatska-logo.webp') }}" alt="ŠK Karpatská 1983 logo">
        @endif
        <div class="main-heading">
            <h1>{{ __('Karpatská tipovačka') }}</h1>
            @if (@isset($tournament->name))
                <h2 class="sub-heading">{{ $tournament->name }}</h2>
            @endif
        </div>
        <img src="{{ asset('storage/img/karpatska-logo.webp') }}" alt="ŠK Karpatská 1983 logo">
    </section>
</header>