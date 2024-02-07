<?php

namespace Database\Seeders;

use App\Models\BCorporation;
use App\Data\BCorporationData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BCorporationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (BCorporationData::BCORPORATIONS as $bcorp) {
            BCorporation::create([
                'id' => $bcorp['id'],
                'name' => $bcorp['name'],
                'website' => $bcorp['website'],
                'country' => $bcorp['country'],
                'employees' => $bcorp['employees'],
                'founded_at' => $bcorp['founded_at'],
                'state' => $bcorp['state'],
            ]);
        }
    }
}
