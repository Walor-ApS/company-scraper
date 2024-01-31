<?php

namespace App\Services;

use App\Models\BCorporation;

class BCorpCompanyService {
  private $crawler;
  private $client;
  private $country;
  private $companies;

  public function setup(\Symfony\Component\Panther\DomCrawler\Crawler $crawler, \Symfony\Component\Panther\Client $client, String $country, $companies) {    
    if ($crawler->filter('.container.mx-auto .font-sans')->text() == "Showing 0 B Corp") {
      return;
    }

    $this->crawler = $crawler;
    $this->client = $client;
    $this->country = $country;
    $this->companies = $companies;

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

      $description = $node->filter('a .mt-4.line-clamp-3.text-fiber-neutral-900')->text();        
      $link = $node->filter('a')->attr('href');

      BCorporation::create([
        'name' => $name,
        'description' => $description,
        'link' => "https://www.bcorporation.net$link",
        'country' => $this->country,
        'founded_at' => $founded_at
      ]);
    });

    //Check if pagination is enabled
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

    // $this->fetchPage();
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