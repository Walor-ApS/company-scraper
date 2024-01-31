<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Actions\ImportCompanyToHubSpot;
use Illuminate\Database\Eloquent\Collection;

class UpdateCompanyService {
  public $companies;

  public function setup(Request $request, Collection $companies) {
    $this->companies = $companies;

    //Update website
    $websites = $request->input('websites', []);
    $companyIds = $request->input('companyIds', []);
    
    foreach ($websites as $key => $website) {
      if ($website != null) {
        $company = $this->companies->find($companyIds[$key]);
        $company->update([
            'website' => $website
        ]);
      }
    }
    
    if ($request->input('action') == 'importAllCompetitors') {
      $this->importAllCompanies();
    }

    $selectedCompanies = $request->input('selected_companies');
    if($selectedCompanies) {
      $this->importSelectedCompanies($selectedCompanies);
    }
  }

  public function importSelectedCompanies($selectedCompanies) {
    foreach ($selectedCompanies as $key => $companyId) {
      $company = $this->companies->find($companyId);
      
      $properties = [
          "country" => $company->country ?? null,
          "phone" => $company->phone ?? null,
          "domain" => $company->website ?? null
      ];
      (new ImportCompanyToHubSpot())->excecute($company, $properties);
    }
  }

  public function importAllCompanies() {
    foreach ($this->companies as $company) {
      $properties = [
          "country" => $company->country ?? null,
          "phone" => $company->phone ?? null,
          "domain" => $company->website ?? null
      ];
      
      (new ImportCompanyToHubSpot())->excecute($company, $properties);
    }
  }
}