<?php

namespace Database\Seeders;

use App\Data\TriggerLeadData;
use App\Models\TriggerLead;
use Illuminate\Database\Seeder;

class TriggerLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TriggerLead::insert(TriggerLeadData::TRIGGERLEADS);
    }
}
