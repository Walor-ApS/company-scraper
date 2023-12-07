<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Actions\ScrapeDanishCompanies;

class CompaniesController extends Controller
{
    public function index(): JsonResponse {        
        // Scrape companies from 20-49
        // $url = 'https://www.proff.dk/segmentering?mainUnit=true&numEmployeesFrom=50&numEmployeesTo=52';    
        // (new ScrapeDanishCompanies())->setup($url);

        // Scrape companies from 159-249
        $url = 'https://www.proff.dk/segmentering?mainUnit=true&numEmployeesFrom=250&numEmployeesTo=262';    
        (new ScrapeDanishCompanies())->setup($url);

        (new CompanyService())->checkCompaniesHasExceededEmployeeNumber(); 

        return response()->json();
   }   

   //Fetch employee history for company
   public function fetchEmployeeHistoryForCompany(Company $company) {
        return $company->employeeHistory()->get();
   }
}