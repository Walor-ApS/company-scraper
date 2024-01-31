<?php

namespace App\Http\Controllers;

use App\Models\BCorporation;
use App\Services\BCorpCompanyService;
use Illuminate\Http\Request;
use Symfony\Component\Panther\Client;

class BCorporationController extends Controller
{
    public function index() {   
      $client = Client::createChromeClient();
      $companies = BCorporation::all();
      
      foreach (config('countries.countries') as $country) {
        $client->request('GET', "https://www.bcorporation.net/en-us/find-a-b-corp/?refinement%5BhqCountry%5D%5B0%5D=$country");
        $crawler = $client->waitFor('#gatsby-focus-wrapper');
        (new BCorpCompanyService())->setup($crawler, $client, $country, $companies);
      }
    
      $client->quit();
      return response()->json();
  }
}
