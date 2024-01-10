<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Municipality;
use App\Actions\TranslateIconNames;

class ScrapeCompanyService {
  private $company;
  private $country;
  
  public function setup(\Symfony\Component\DomCrawler\Crawler $website, String $country): void {
    $this->company = new Company();
    $this->country = $country;
  
    $website->filter('.MuiGrid-root.MuiGrid-container.MuiGrid-spacing-md-2.css-1tw4074')->each(function ($node) {                
        $node->filter('.MuiBox-root .OfficialCompanyInformationCard-propertyList')->each(function ($child) {
          $this->fetchCompanyInformation($child);
        });
    });
  
    if ( $this->company->municipality_code ) {
      $municipality = Municipality::updateOrCreate([
        'code' => $this->company->municipality_code,
        'country' => $this->country
      ], [
        'name' => $this->company->municipality_name,
      ]);
    }

    Company::create([
      'cvr' => $this->company->cvr,
      'name' => $this->company->name,
      'founded_at' => $this->company->founded_at,
      'address' => $this->company->address,
      'company_type' => $this->company->company_type,
      'phone' => $this->company->phone,
      'country' => $this->country,
      'municipality_id' => $municipality->id ?? null
    ]);
  }

  public function fetchCompanyInformation(mixed $node): void {
    $fieldName = $node->filter('.OfficialCompanyInformationCard-property')->text();
    $fieldValue = $node->filter('.OfficialCompanyInformationCard-propertyValue')->text();  
    $translatedWords = (new TranslateIconNames())->index($this->country);

    if ($fieldName == $translatedWords['name']) {
      $this->company->name = $fieldValue;
    }  
    elseif ($fieldName == $translatedWords['cvr']) {
      $this->company->cvr = $fieldValue;
    }  
    elseif ($fieldName == $translatedWords['founded_at']) {
      $this->company->founded_at = $fieldValue;
    }
    elseif ($fieldName == $translatedWords['phone']) {
      $this->company->phone = $fieldValue;
    }  
    elseif ($fieldName == $translatedWords['address']) {
      $this->company->address = $fieldValue;

      $municipality = explode(',', $fieldValue)[1] ?? null;
      if ( $municipality ) {
        $this->company->municipality_name = trim(preg_replace('/[0-9]+/', '', $municipality));      
        $this->company->municipality_code = trim(str_replace($this->company->municipality_name, '', $municipality));        
      };
    }  
    elseif ($fieldName == $translatedWords['company_type']) {
      $this->company->company_type = $fieldValue;
    }  
    elseif ($fieldName == $translatedWords['employees']) {
      if (str_contains($fieldValue, '-')) {
        $this->company->employees_range = trim($fieldValue);
        return;
      }
      $this->company->employees = $fieldValue;
    }  
  }
}