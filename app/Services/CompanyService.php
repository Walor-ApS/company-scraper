<?php

namespace App\Services;

use App\Models\Company;
use App\Actions\TranslateIconNames;
use App\Models\CompanyEmployee;
use Carbon\Carbon;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class CompanyService {
  private $company;
  private $site;
  private $country;

  public function setup(String $site, String $url, String $country): void {
    $this->site = $site;
    $this->country = $country;

    $browser = new HttpBrowser(HttpClient::create());
    $website = $browser->request('GET', $url);

    $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();
    
    //Handle pagination
    for ($i = 1; $i <= $maxPages; $i++) {
        $website = $browser->request('GET', "$url&page=$i");
        $this->scrapeCompanies($website);
    } 
  }

  public function scrapeCompanies(\Symfony\Component\DomCrawler\Crawler $website): void {      
    $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) {            
        $link_href = $node->filter('div div h2 a')->attr('href');

        $browser = new HttpBrowser(HttpClient::create());
        $website = $browser->request('GET', "$this->site$link_href");

        //Scrape Company
        $this->company = new Company();

        $website->filter('.MuiGrid-root.MuiGrid-container.MuiGrid-spacing-md-2.css-1tw4074')->each(function ($node) {                
            $node->filter('.MuiBox-root .OfficialCompanyInformationCard-propertyList')->each(function ($child) {
              $this->fetchCompanyInformation($child);
            });
        });

        $company = Company::updateOrCreate([
          'cvr' => $this->company->cvr,
          'name' => $this->company->name,
        ],
        [
            'founded_at' => $this->company->founded_at,
            'address' => $this->company->address,
            'company_type' => $this->company->company_type,
            'phone' => $this->company->phone,
            'country' => $this->country
        ]);

        CompanyEmployee::create([
          'company_id' => $company->id,
          'year' => Carbon::now()->year,
          'month' => Carbon::now()->month,
          'week' => Carbon::now()->weekNumberInMonth,
          'employees' => $this->company->employees,
          'employees_range' => $this->company->employees_range,
        ]);
    });  
  }  

  public function fetchCompanyInformation($node): void {
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