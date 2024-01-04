<?php

namespace App\Services;

use App\Models\Company;
use App\Actions\TranslateIconNames;
use App\Models\CompanyEmployee;
use Carbon\Carbon;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class EmployeeService {
  private $company;
  private $country;
  private $site;
  private $translatedWords;
  private $browser;
  private $companies;
  private $employeeData;

  public function setup(String $site, String $url, String $country): void {
    $this->country = $country;
    $this->site = $site;
    $this->translatedWords = (new TranslateIconNames())->index($this->country);;
    
    $this->browser = new HttpBrowser(HttpClient::create());
    $website = $this->browser->request('GET', $url);
    
    $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();
    
    $this->companies = Company::all();

    //Handle pagination
    for ($i = 1; $i <= $maxPages; $i++) {
        $website = $this->browser->request('GET', "$url&page=$i");
        $this->scrapeEmployees($website);
    }
    CompanyEmployee::insert($this->employeeData);
  }

  public function scrapeEmployees(\Symfony\Component\DomCrawler\Crawler $website): void {   
    $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) { 
      $name = $node->filter('div div h2 a')->text();      
      $cvr = str_replace($this->translatedWords["cvr"], "", $node->filter('div div div span')->text());

      $this->company = $this->companies->first(function ($company) use ($cvr, $name) {
        return str_contains($cvr, $company->cvr) && $company->name == $name;
      });
      
      if (! $this->company) {
        //The company hasn't been created yet, so we create it now
        $link_href = $node->filter('div div h2 a')->attr('href');

        $website = $this->browser->request('GET', "$this->site$link_href");

        $this->company = (new ScrapeCompanyService())->setup($website, $this->country);
        return;
      }
      
      //Scraping employee count
      $this->scrapeEmployeeCount($node);
    });    
  }
  
  public function scrapeEmployeeCount(mixed $node): void {
    $node->filter('.PrivateHiddenCss-root .MuiBox-root .CardHeader-propertyBlock')->each(function ($node) {     
      if (str_contains($node->text(), $this->translatedWords['employees_short'])) {
        $employees = str_replace($this->translatedWords['employees_short'], "", $node->text());
        if (str_contains($employees, '-')) {
          $this->company->employees_range = trim($employees);
          return;
        }
        $this->company->employees = $employees;
      }
    });
    
    $this->employeeData[] = [
      'company_id' => $this->company->id,
      'year' => Carbon::now()->year,
      'month' => Carbon::now()->month,
      'week' => Carbon::now()->weekNumberInMonth,
      'employees' => $this->company->employees,
      'employees_range' => $this->company->employees_range,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now(),
    ];
  }
}