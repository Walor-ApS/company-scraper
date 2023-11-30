<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class CompaniesController extends Controller
{
    public function index() {
        $browser = new HttpBrowser(HttpClient::create());
        $website = $browser->request('GET', 'https://datacvr.virk.dk/');

        // $companies = $website->filter('.soegeresultaterTabel .row')->each(function ($node) {
        //     echo "IN";
        //     $company_name = $node->filter('div span')->text();
            
        //     return [
        //         'company_name' => $company_name
        //     ];
        // });

        // return $companies;

        return $website->getResponse();
    }
}