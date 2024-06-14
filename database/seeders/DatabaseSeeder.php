<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'dani9',
            'email' => 'dani.strba@gmail.com',
            'password' => Hash::make('Valiant74210'),
        ]);

        DB::table('games')->insert([
            'home_team' => 'Nemecko',
            'away_team' => 'Škótsko',
            'home_team_abb' => 'GER',
            'away_team_abb' => 'SCO',
            'game_date' => '2024-06-14 21:00',
        ]);

        DB::table('game_predictions')->insert([
            'user_id' => 1,
            'game_id' => 1,
            'home_team_goals' => 3,
            'away_team_goals' => 0,
        ]);
    }
}
