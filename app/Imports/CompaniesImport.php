<?php

namespace App\Imports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;

class CompaniesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if($row[1] === 'Startdato') {
            return null;
        }

        if(in_array($row[0], ['Navn', null, '', 'Fritekst'], true)) {
            return null;
        }

        if($row[3] === null) {
            return null;
        }



        logger($row);
        return Company::create([
            'municipality_id' => 55,
            'country' => 'DK',
            'cvr' => $row[0],
            'founded_at' => now(),
            // 2005-07-01 to datetime
            'ended_at' => now(),
            'name' => $row[3],
            'address' => $row[4] ?? null,
            'zip_code' => $row[5] ?? null,
            'city' => $row[6] ?? null,
            'company_type' => $row[7] ?? null,
            'industry' => $row[8] ?? null,
            'phone' => $row[9] ?? null,
            'email' => $row[10] ?? null,
            'advertising_protected' => false,
        ]);
    }
}
