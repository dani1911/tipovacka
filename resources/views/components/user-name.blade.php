@props(['tournament', 'user'])
<a href="{{ route('tournament.user', [$tournament, $user]) }}" class="flex-1">
    <span>
        {{ $user->name }}
    </span>
</a>