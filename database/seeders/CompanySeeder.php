<?php

namespace Database\Seeders;

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
        // Try to create one company
//        Company::create([
//            'municipality_id' => 55,
//            'country' => 'DK',
//            'cvr' => '12345678',
//            'founded_at' => now(),
//            // 2005-07-01 to datetime
//            'ended_at' => now(),
//            'name' => 'Test Company',
//            'address' => 'Test Address',
//            'zip_code' => '1234',
//            'city' => 'Test City',
//            'company_type' => 'Test Company Type',
//            'industry' => 'Test Industry',
//            'phone' => '12345678',
//            'email' => 'a@a.com',
//            'advertising_protected' => false,
//        ]);
//
//        exit;
        Excel::import(new CompaniesImport, storage_path('app/public/companies/cph.xlsx'));
    }
}
