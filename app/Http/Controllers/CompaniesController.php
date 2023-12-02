<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;

class CompaniesController extends Controller
{
    public function index() {

        // * First version
        $client = new HttpBrowser(HttpClient::create());
        $crawler = $client->request('GET', 'https://datacvr.virk.dk/soegeresultater?sideIndex=0&enhedstype=virksomhed&antalAnsatte=ANTAL_20_49&virksomhedsstatus=aktiv%252Cnormal&size=10');            
        
        // * Second version with chrome client
        // $client = Client::createChromeClient();    // create a chrome client
        // $crawler = $client->request('GET', 'https://datacvr.virk.dk/soegeresultater?sideIndex=0&enhedstype=virksomhed&antalAnsatte=ANTAL_20_49&virksomhedsstatus=aktiv%252Cnormal&size=10');            
        // $client->waitFor('div');
        
        return $crawler->html();
    }
}