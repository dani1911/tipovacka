@props([
    'route' => null,
    'tournament' => null,
    'label',
    'icon',
    'class' => '',
])

<li class="nav-item">
    <a class="nav-link" href="{{ $tournament ? route('tournament.' . $route, $tournament) : route($route) }}">
        <x-dynamic-component :component="$icon" class="w-9 md:w-7 h-9 md:h-7 {{ $class }}" />
        <span>{{ $label }}</span>
    </a>
</li>