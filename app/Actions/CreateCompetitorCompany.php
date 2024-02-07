<?php

namespace App\Actions;

use App\Models\Competitor;
use App\Models\CompetitorCompany;

class CreateCompetitorCompany {
  public function excecute(mixed $company, String $competitorCvrName, String $competitorName): void {    
    //Create or update Competitor
    $competitor = Competitor::updateOrCreate([
      'cvr_name' => $competitorCvrName  
    ], [
      'name' => $competitorName
    ]);

    //Create or update Company
    $parsedUrl = parse_url($company[1]);
    $fixedHostUrl = str_replace("www.", "", $parsedUrl["host"]);
    $companyUrl = explode(".", $fixedHostUrl)[0];
    
    $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];    

    CompetitorCompany::updateOrCreate([
      'name' => ucfirst($companyUrl),
      'website' => $baseUrl,
      'competitor_id' => $competitor->id
    ]);
  }
}