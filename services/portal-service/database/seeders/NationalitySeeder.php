<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/nationalities.json');

        if (! file_exists($path)) {
            throw new RuntimeException(
                "Nationality dataset not found: {$path}"
            );
        }

        $nationalities = json_decode(
            file_get_contents($path),
            true
        );

        DB::table('nationalities')->delete();

        DB::table('nationalities')->insert($nationalities);
    }
}