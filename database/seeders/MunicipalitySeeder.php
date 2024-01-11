<?php

namespace Database\Seeders;

use App\Data\MunicipalityData;
use App\Models\Municipality;
use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Municipality::insert(MunicipalityData::MUNICIPALITES);
    }
}
