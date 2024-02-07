<?php

namespace App\Http\Controllers;

use App\Models\BCorporation;
use App\Services\BCorpCompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Panther\Client;

class BCorporationController extends Controller
{
  public function index(): JsonResponse {
    $client = Client::createChromeClient();
    $companies = BCorporation::all();

    $employeeNumbers = ["0", "1-9", "10-49", "50-249", "250-999", "1000+"];

    foreach (config('countries.countries') as $country) {
      foreach ($employeeNumbers as $employeeNumber) {        
        $client->request('GET', "https://www.bcorporation.net/en-us/find-a-b-corp/?refinement%5BhqCountry%5D%5B0%5D=$country&refinement%5Bsize%5D%5B0%5D=$employeeNumber");
        $crawler = $client->waitFor('#gatsby-focus-wrapper .ais-Hits');
        sleep(1);
        (new BCorpCompanyService())->setup($crawler, $client, $country, $employeeNumber, $companies);
      }
    }
  
    $client->quit();
    return response()->json();
  }
}
