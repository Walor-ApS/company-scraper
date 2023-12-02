<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Excel;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = Storage::disk('public')->get('companies/cph.xlsx');

        Excel::filter('chunk')->load($file)->chunk(100, function ($results) {
            dd($results);
        });
    }
}
