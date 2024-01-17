<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use App\Actions\EmployeeCheckAction;

set_time_limit(999999999009);

class CompaniesController extends Controller
{
    public function fetchCompanies(): JsonResponse {   
      //Danish
      // //37-49
      // $url = 'https://www.proff.dk/segmentering?numEmployeesFrom=51&numEmployeesTo=52&mainUnit=true';
      // (new CompanyService())->setup('https://www.proff.dk', $url, 'DK');

      // //220-249
      // $url = 'https://www.proff.dk/segmentering?numEmployeesFrom=220&numEmployeesTo=249&mainUnit=true';
      // (new CompanyService())->setup('https://www.proff.dk', $url, 'DK');

      //Sweden
      //37-49
      $url = 'https://www.proff.se/segmentering?numEmployeesFrom=51&numEmployeesTo=52';
      (new CompanyService())->setup('https://www.proff.se', $url, 'SV');
      
      // //220-249
      // $url = 'https://www.proff.se/segmentering?numEmployeesFrom=220&numEmployeesTo=249';
      // (new CompanyService())->setup('https://www.proff.se', $url, 'SV');
      
      // //Norway
      // //37-49
      // $url = 'https://www.proff.no/segmentering?numEmployeesFrom=51&numEmployeesTo=52&mainUnit=true';
      // (new CompanyService())->setup('https://www.proff.no', $url, 'NO');
      
      // //220-249
      // $url = 'https://www.proff.no/segmentering?numEmployeesFrom=220&numEmployeesTo=249&mainUnit=true';
      // (new CompanyService())->setup('https://www.proff.no', $url, 'NO');
      
      // //Finland
      // //20-49
      // $url = 'https://www.proff.fi/segmentointi?employeeRange=50%20-%2099';
      // (new CompanyService())->setup('https://www.proff.fi', $url, 'FI');
      
      // //159-249
      // $url = 'https://www.proff.fi/segmentointi?employeeRange=100%20-%20249';
      // (new CompanyService())->setup('https://www.proff.fi', $url, 'FI'); 

      return response()->json();
   }

   public function fetchEmployees(): JsonResponse {
      (new EmployeeService())->setup();
   
      return response()->json();
   }

   //Fetch employee history for company
   public function fetchEmployeeHistoryForCompany(Company $company) {
        return $company->employeeHistory()->get();
   }
}