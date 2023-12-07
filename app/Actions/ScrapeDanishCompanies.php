<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\Municipality;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class ScrapeDanishCompanies {
  public function setup(String $url): void {
    $browser = new HttpBrowser(HttpClient::create());
    $website = $browser->request('GET', $url);

    $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();
    
    //Handle pagination
    for ($i = 1; $i <= 1; $i++) {
      $website = $browser->request('GET', "$url&page=$i");
      $this->execute($website);
    }         
  }

  public function execute(\Symfony\Component\DomCrawler\Crawler $website): void {
    $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) {            
      $cvr = substr($node->filter('.CardHeader-propertyList.MuiBox-root.css-gf5as1')->text(), 6, 8);

      $response = Http::withHeaders([
          'Authorization' => 'cvr.dev_d1932811ecc4d5906d28c44d3a3fbdfb'
          ])->get("https://api.cvr.dev/api/cvr/virksomhed?cvr_nummer=$cvr");

      $jsonData = $response->json()[0];

      if (! $jsonData) {
          return response('JSON data was not found', 404);
      }
      
      //Address info
      $addressInfo = $jsonData['virksomhedMetadata']['nyesteBeliggenhedsadresse'];
      $country = $addressInfo['landekode'];
      $municipality = ucfirst(strtolower($addressInfo['kommune']['kommuneNavn']));
      $zip_code = $addressInfo['postnummer'];
      $city = $addressInfo['postdistrikt'];
      $street_name = $addressInfo['vejnavn'];
      $house_number = $addressInfo['husnummerFra'];
      $house_letter = $addressInfo['bogstavFra'];
      $address = "$street_name $house_number$house_letter, $zip_code $city";

      //Create municipality
      $municipality = Municipality::updateOrCreate([
          'name' => $municipality,
          'code' => $addressInfo['kommune']['kommuneKode']
      ]);

      $link = $node->filter('.MuiTypography-root.MuiTypography-inherit.MuiLink-root.MuiLink-underlineHover.css-105wgyd')->attr('href');

      $company = Company::updateOrCreate([
          'name' => $jsonData['virksomhedMetadata']['nyesteNavn']['navn'],
          'cvr' => $cvr,
          'founded_at' => $jsonData['virksomhedMetadata']['stiftelsesDato'],
          'employees' => $jsonData['virksomhedMetadata']['nyesteErstMaanedsbeskaeftigelse']['antalAnsatte'],
          'address' => $address,
          'zip_code' => $zip_code,
          'country' => $country,
          'city' => $city,
          'municipality_id' => $municipality->id,
          'phone' => $jsonData['telefonNummer'][0]['kontaktoplysning'] ?? null,
          'email' => $jsonData['elektroniskPost'][0]['kontaktoplysning'] ?? null,                
          'advertising_protected' => $jsonData['reklamebeskyttet'],
          'company_type' => $jsonData['virksomhedMetadata']['nyesteVirksomhedsform']['langBeskrivelse'],
          'link' => $link
      ]);

      (new CompanyService())->storeEmployeeHistory($jsonData, $company);
    });
  }
}