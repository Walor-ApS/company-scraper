<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MunicipalitySeeder::class);
        $this->command->info('Municipalities seeded');

        $this->call(CompanySeeder::class);
        $this->command->info('Companies seeded');

        $this->call(CompanyEmployeeSeeder::class);
        $this->command->info('Company employees seeded');
    }
}
