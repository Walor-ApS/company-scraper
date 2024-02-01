<?php

namespace Database\Seeders;

use App\Models\BCorporation;
use App\Data\BCorporationData;
use Illuminate\Database\Seeder;

class BCorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      BCorporation::insert(BCorporationData::BCORPORATIONS);
    }
}
