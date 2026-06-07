<div>
    <h3 class="title-h3">{{ __('Group stage games') }}</h3>
    <section class="games-list">
        @forelse ($games as $game)
            <x-game-box :game="$game" />
        @empty
            <p>{{ __('No games added yet') }}</p>
        @endforelse

        {{-- <article class="game-box">
            <section class="game-box__header">
                <span class="badge">
                    16.06.2026 21:00
                </span>
                <span class="badge">
                    Skupina A
                </span>
            </section>
            <section class="game-box__body">
                <div class="game-box__game">
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/sk.png" alt="">
                            </div>
                            <span>Slovensko</span>
                        </div>
                        <div class="game-box__score">
                            <span class="badge">2</span>
                        </div>
                    </div>
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/ba.png" alt="">
                            </div>
                            <span title="Bosna a Hercegovina">Bosna a Hercegovina</span>
                        </div>
                        <div class="game-box__score">
                            <span class="badge">2</span>
                        </div>
                    </div>
                </div>
                <div class="game-box__stats">
                    <span class="badge">10</span>
                </div>
            </section>
        </article>
        <article class="game-box">
            <section class="game-box__header">
                <span class="badge">
                    16.06.2026 21:00
                </span>
                <span class="badge">
                    Skupina A
                </span>
            </section>
            <section class="game-box__body">
                <div class="game-box__game">
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/sk.png" alt="">
                            </div>
                            <span>Slovensko</span>
                        </div>
                        <div class="game-box__score">
                            <span class="badge">2</span>
                        </div>
                        <div class="game-box__prediction incorrect">
                            1
                        </div>
                    </div>
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/ba.png" alt="">
                            </div>
                            <span>Bosna a Hercegovina</span>
                        </div>
                        <div class="game-box__score">
                            <span class="badge">2</span>
                        </div>
                        <div class="game-box__prediction incorrect">
                            1
                        </div>
                    </div>
                </div>
                <div class="game-box__stats">
                    <span class="">0</span>
                </div>
            </section>
        </article>
        <article class="game-box">
            <section class="game-box__header">
                <span class="badge">
                    16.06.2026 21:00
                </span>
                <span class="badge">
                    Skupina A
                </span>
            </section>
            <section class="game-box__body">
                <div class="game-box__game">
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/sk.png" alt="">
                            </div>
                            <span>Slovensko</span>
                        </div>
                        <div class="game-box__prediction">
                            1
                        </div>
                    </div>
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/ba.png" alt="">
                            </div>
                            <span>Bosna a Hercegovina</span>
                        </div>
                        <div class="game-box__prediction">
                            1
                        </div>
                    </div>
                </div>
                <div class="game-box__action">
                    <button class="btn">
                        <x-tabler-edit />
                    </button>
                </div>
            </section>
        </article>
        <article class="game-box">
            <section class="game-box__header">
                <span class="badge">
                    16.06.2026 21:00
                </span>
                <span class="badge">
                    Skupina A
                </span>
            </section>
            <section class="game-box__body">
                <div class="game-box__game">
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/sk.png" alt="">
                            </div>
                            <span>Slovensko</span>
                        </div>
                    </div>
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/ba.png" alt="">
                            </div>
                            <span>Bosna a Hercegovina</span>
                        </div>
                    </div>
                </div>
                <div class="game-box__action">
                    <button class="btn">
                        <x-tabler-new-section />
                    </button>
                </div>
            </section>
        </article>
        <article class="game-box">
            <section class="game-box__header">
                <span class="badge">
                    16.06.2026 21:00
                </span>
                <span class="badge">
                    Skupina A
                </span>
            </section>
            <section class="game-box__body">
                <div class="game-box__game">
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/sk.png" alt="">
                            </div>
                            <span>Slovensko</span>
                        </div>
                    </div>
                    <div class="game-box__row">
                        <div class="game-box__team">
                            <div class="game-box__flag">
                                <img src="https://flagcdn.com/w320/ba.png" alt="">
                            </div>
                            <span>Bosna a Hercegovina</span>
                        </div>
                    </div>
                </div>
            </section>
        </article> --}}
    </section>
    @auth
        <livewire:predictions.manage-game-prediction />
    @endauth
</div>
