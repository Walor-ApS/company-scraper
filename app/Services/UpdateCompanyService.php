<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Actions\ImportCompanyToHubSpot;

class UpdateCompanyService {
  public function setup(Request $request, $model) {
    $websites = $request->input('websites', []);
    $companyIds = $request->input('companyIds', []);
    
    foreach ($websites as $key => $website) {
      if ($website != null) {
        $company = $model::find($companyIds[$key]);
        $company->update([
            'website' => $website
        ]);
      }
    }

    $selectedCompanies = $request->input('selected_companies');
    if ($selectedCompanies) {
      foreach ($selectedCompanies as $key => $companyId) {
        $company = $model::find($companyId);
        
        $properties = [
            "country" => $company->country ?? null,
            "phone" => $company->phone ?? null,
            "domain" => $company->website ?? null
        ];
        (new ImportCompanyToHubSpot())->excecute($company, $properties);
      }
    }
  }
}