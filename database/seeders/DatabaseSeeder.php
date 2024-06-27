<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('stages')->insert(
            [
                'id' => 1,
                'name' => 'Skupina A',
                'abbreviation' => 'A'
            ],
            [
                'id' => 2,
                'name' => 'Skupina B',
                'abbreviation' => 'B'
            ],
            [
                'id' => 3,
                'name' => 'Skupina C',
                'abbreviation' => 'C'
            ],
            [
                'id' => 4,
                'name' => 'Skupina D',
                'abbreviation' => 'D'
            ],
            [
                'id' => 5,
                'name' => 'Skupina E',
                'abbreviation' => 'E'
            ],
            [
                'id' => 6,
                'name' => 'Skupina F',
                'abbreviation' => 'F'
            ],
            [
                'id' => 7,
                'name' => 'Osemfinále',
                'abbreviation' => 'L16'
            ],
            [
                'id' => 8,
                'name' => 'Štvrťfinále',
                'abbreviation' => 'QF'
            ],
            [
                'id' => 9,
                'name' => 'Semifinále',
                'abbreviation' => 'SF'
            ],
            [
                'id' => 10,
                'name' => 'EURO',
                'abbreviation' => 'FIN'
            ],
        );

        DB::table('teams')->insert(
            [
                'name' => 'Albánsko',
                'abbreviation' => 'alb',
            ],
            [
                'name' => 'Anglicko',
                'abbreviation' => 'eng',
            ],
            [
                'name' => 'Belgicko',
                'abbreviation' => 'bel',
            ],
            [
                'name' => 'Česko',
                'abbreviation' => 'cze',
            ],
            [
                'name' => 'Chorvátsko',
                'abbreviation' => 'hrv',
            ],
            [
                'name' => 'Dánsko',
                'abbreviation' => 'dnk',
            ],
            [
                'name' => 'Francúzsko',
                'abbreviation' => 'fra',
            ],
            [
                'name' => 'Gruzínsko',
                'abbreviation' => 'geo',
            ],
            [
                'name' => 'Holandsko',
                'abbreviation' => 'nld',
            ],
            [
                'name' => 'Maďarsko',
                'abbreviation' => 'hun',
            ],
            [
                'name' => 'Nemecko',
                'abbreviation' => 'deu',
            ],
            [
                'name' => 'Poľsko',
                'abbreviation' => 'pol',
            ],
            [
                'name' => 'Portugalsko',
                'abbreviation' => 'prt',
            ],
            [
                'name' => 'Rakúsko',
                'abbreviation' => 'aut',
            ],
            [
                'name' => 'Rumunsko',
                'abbreviation' => 'rou',
            ],
            [
                'name' => 'Škótsko',
                'abbreviation' => 'sco',
            ],
            [
                'name' => 'Slovensko',
                'abbreviation' => 'svk',
            ],
            [
                'name' => 'Slovinsko',
                'abbreviation' => 'svn',
            ],
            [
                'name' => 'Španielsko',
                'abbreviation' => 'esp',
            ],
            [
                'name' => 'Srbsko',
                'abbreviation' => 'srb',
            ],
            [
                'name' => 'Švajčiarsko',
                'abbreviation' => 'che',
            ],
            [
                'name' => 'Taliansko',
                'abbreviation' => 'ita',
            ],
            [
                'name' => 'Turecko',
                'abbreviation' => 'tur',
            ],
            [
                'name' => 'Ukrajina',
                'abbreviation' => 'ukr',
            ],
            [
                'name' => 'Tím',
                'abbreviation' => 'pla',
            ],
        );
    }
}
