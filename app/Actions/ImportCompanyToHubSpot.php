<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class ImportCompanyToHubSpot {
  function excecute($company, Array $properties) {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . config('services.hubspot.api_key'),
        'Content-Type' => 'application/json',
    ])->post("https://api.hubapi.com/crm/v3/objects/companies", [
        'properties' => $properties
    ]);

    if ($response->status() == 201) {
      $company->update([
        "state" => "Imported"
      ]);
    }
  }
}
