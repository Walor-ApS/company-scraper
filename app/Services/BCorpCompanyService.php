<?php

namespace App\Services;

use App\Models\BCorporation;
use Symfony\Component\Panther\Client;

class BCorpCompanyService {
  private $crawler;
  private $client;
  private $country;
  private $companies;
  private $employees;

  public function setup(\Symfony\Component\Panther\DomCrawler\Crawler $crawler, \Symfony\Component\Panther\Client $client, String $country, String $employees, $companies) {    
    if ($crawler->filter('.container.mx-auto .font-sans')->text() == "Showing 0 B Corp") {
      return;
    }

    $this->crawler = $crawler;
    $this->client = $client;
    $this->country = $country;
    $this->companies = $companies;
    $this->employees = $employees;

    $this->fetchPage();
  }

  public function fetchPage() {
    $this->crawler->filter('.ais-Hits .ais-Hits-item')->each(function ($node) {
      $name = $node->filter('a .text-xl.font-medium.text-black')->text();
      
      $founded_at = "";
      if ($node->filter('a .whitespace-nowrap span')->count() == 1) {
        $founded_at = $node->filter('a .whitespace-nowrap span')->text();
      }
      
      //Check if company exist
      $company = $this->companies->first(function ($company) use ($name, $founded_at) {
        return $company->name == $name && $company->founded_at == $founded_at;
      });      
      
      if ($company) {
        //Company already exists
        return;
      }

      $link = $node->filter('a')->attr('href');      

      $client = Client::createChromeClient(null, null, [
          'port' => 8080
      ]);
      $client->request('GET', "https://www.bcorporation.net$link");
      $crawler = $client->waitFor('#___gatsby');
      sleep(1);
      
      $website = $crawler->filter('main .grid.grid-cols-6 .flex-col.bg-gray-light div a')->attr("href");
      
      BCorporation::create([
        'name' => $name,
        'website' => $website,
        'country' => $this->country,
        'employees' => $this->employees,
        'founded_at' => $founded_at
      ]);
      $client->quit();
    });

    if ($this->crawler->filter('.container.mx-auto .text-center.text-fiber-neutral-500.mt-10')->count() == 0) {
      //No pagination is enabled
      return;
    }

    //Handles pagination
    $paginationText = $this->crawler->filter('.container.mx-auto .text-center.text-fiber-neutral-500.mt-10')->text();
    if ($this->isLastPage($paginationText) == 1) {
      //This is the last page
      return;
    }

    $next = "Next";
    $jsCode = "document.querySelector('[aria-label=$next]').click();";

    $this->client->executeScript($jsCode);
    sleep(1);
    $this->crawler = $this->client->refreshCrawler();

    $this->fetchPage();
 }   

  public function isLastPage(String $paginationText): Bool {
    if (preg_match('/Showing (\d+)-(\d+) of (\d+)/', $paginationText, $matches)) {
        $end = (int)$matches[2];
        $total = (int)$matches[3];

        return $end === $total;
    }
    return false;
  }
}