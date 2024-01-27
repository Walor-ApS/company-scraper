<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class ImportCompanyToHubSpot {
  function excecute($company, Array $properties) {    
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('HUB_SPOT_ACCESS_TOKEN'),
        'Content-Type' => 'application/json',
    ])->post("https://api.hubapi.com/crm/v3/objects/companies", [
        'properties' => $properties
    ]);

    $company->update([
      "state" => "Imported"
    ]);
  }
}