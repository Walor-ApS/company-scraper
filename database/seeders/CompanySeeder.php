<?php

namespace Database\Seeders;

use App\Data\CompanyData;
use App\Imports\CompaniesImport;
use App\Imports\CompanyImport;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(CompanyData::COMPANIES as $company) {
            Company::firstOrCreate([
                'cvr' => $company['cvr'],
            ], [...$company, 'created_at' => now(), 'updated_at' => now(),]);
        }
    }
}
