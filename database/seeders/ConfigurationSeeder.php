<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configuration')->insert([
            [
                'key' => 'REGISTRATIONS_ALLOWED',
                'value' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'CURRENT_PHASE',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ACTIVE_TOURNAMENT',
                'value' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
