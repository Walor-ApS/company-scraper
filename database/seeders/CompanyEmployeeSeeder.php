<?php

namespace Database\Seeders;

use App\Data\CompanyEmployeeData;
use App\Models\CompanyEmployee;
use Illuminate\Database\Seeder;

class CompanyEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       CompanyEmployee::insert(CompanyEmployeeData::COMPANIES_EMPLOYEES);
    }
}
