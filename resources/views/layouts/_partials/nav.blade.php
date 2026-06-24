<nav class="main-nav">
    <ul class="content nav-list">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <x-tabler-home class="w-9 md:w-7 h-9 md:h-7" />
                <span>{{ __('Home') }}</span>
            </a>
        </li>
        <x-nav-item
            route="games"
            :tournament="$tournament ?? null"
            label="{{ __('Games') }}"
            icon="tabler-scoreboard"
        />
        <x-nav-item
            route="groups"
            :tournament="$tournament ?? null"
            label="{{ __('Groups') }}"
            icon="heroicon-o-trophy"
        />
        <x-nav-item
            route="knockout"
            :tournament="$tournament ?? null"
            label="{{ __('Bracket') }}"
            icon="tabler-sitemap"
            class="rotate-90"
        />
        <x-nav-item
            route="users"
            :tournament="$tournament ?? null"
            label="{{ __('Users') }}"
            icon="heroicon-o-numbered-list"
        />
        @auth
            <li class="nav-item">
                <div class="nav-link" href="">
                    <x-tabler-dots-vertical-f class="w-7 h-7 hidden md:block" />
                    <x-tabler-dots-f class="w-9 h-9 md:hidden" />
                    <span>{{ __('More') }}</span>
                </div>
                <ul class="sub-nav-list text-2xl md:text-base">
                    <li class="sub-nav-item">
                        <a href="{{ route('tournaments') }}" class="sub-nav-link">{{ __('Previous tournaments') }}</a>
                    </li>
                    {{-- <li class="sub-nav-item">
                        <a href="" class="sub-nav-link">{{ __('Settings') }}</a>
                    </li> --}}
                    <li class="sub-nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button
                                class="sub-nav-link w-full text-left"
                                type="submit"
                                data-test="logout-button">{{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        @endauth
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <x-tabler-user-circle class="w-9 md:w-7 h-9 md:h-7" />
                    <span>{{ __('Login') }}</span>
                </a>
            </li>
        @endguest
    </ul>
</nav>