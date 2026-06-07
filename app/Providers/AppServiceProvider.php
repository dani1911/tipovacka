<?php

namespace App\Providers;

use App\Models\Game;
use App\Observer\GameObserver;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Game::observe(GameObserver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'red' => Color::Red,
            'rose' => Color::Rose,
            'sky' => Color::Sky,
            'green' => Color::Green,
            'fuchsia' => Color::Fuchsia,
            'zinc' => Color::Zinc,
            'grey' => Color::Gray,
            'emerald' => Color::Emerald,
            'amber' => Color::Amber,
            'yellow' => Color::Yellow,
        ]);

        Gate::after(function ($user, $ability, $result) {
            if ($result === false) {
                logger("Gate denied: {$ability} for user {$user->id}");
            }
        });
    }
}
