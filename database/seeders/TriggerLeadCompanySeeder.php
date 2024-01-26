<?php

namespace Database\Seeders;

use App\Data\TriggerLeadCompanyData;
use App\Models\Company;
use Illuminate\Database\Seeder;

class TriggerLeadCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::insert(TriggerLeadCompanyData::TRIGGERLEADSCOMPANIES);
    }
}
