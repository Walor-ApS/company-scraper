<?php

namespace Database\Seeders;

use App\Data\BCorporationData;
use App\Models\BCorporation;
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
