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
                'name' => 'EURO',
                'abbreviation' => 'FIN'
            ],
        );
    }
}
