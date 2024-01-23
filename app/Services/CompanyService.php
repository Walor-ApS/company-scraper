<?php

namespace App\Services;

use App\Models\Company;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class CompanyService {
  private $site;
  private $country;
  private $browser;
  private $companies;

  public function setup(String $site, String $url, String $country): void {
    $this->site = $site;
    $this->country = $country;

    $this->browser = new HttpBrowser(HttpClient::create());
    $website = $this->browser->request('GET', $url);

    $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();
    $this->companies = Company::all();

    //Handle pagination
    for ($i = 1; $i <= $maxPages; $i++) {
        $website = $this->browser->request('GET', "$url&page=$i");
        $this->scrapeCompanies($website);
    }
  }

  public function scrapeCompanies(\Symfony\Component\DomCrawler\Crawler $website): void {
    $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) {
      $name = $node->filter('div div h2 a')->text();
      $cvr = $node->filter('div div div span')->text();

      $company = $this->companies->first(function ($company) use ($cvr, $name) {
        return str_contains($cvr, $company->cvr) && $company->name == $name;
      });
      
      if ($company && str_contains($cvr, $company->cvr)) {
        //Company already exists
        return;
      }

      $link_href = $node->filter('div div h2 a')->attr('href');
      $website = $this->browser->request('GET', "$this->site$link_href");

      (new ScrapeCompanyService())->setup($website, $this->country);
    });
  }
}
