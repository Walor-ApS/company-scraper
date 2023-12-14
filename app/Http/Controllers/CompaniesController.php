<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use App\Actions\EmployeeCheckAction;

set_time_limit(999999999009);

class CompaniesController extends Controller
{
    public function index(): JsonResponse {   
        //Danish
        //20-49
        $url = 'https://www.proff.dk/segmentering?numEmployeesFrom=20&numEmployeesTo=49&mainUnit=true';
        (new CompanyService())->setup('https://www.proff.dk', $url, 'DK');

        //159-249
        $url = 'https://www.proff.dk/segmentering?numEmployeesFrom=159&numEmployeesTo=249&mainUnit=true';        
        (new CompanyService())->setup('https://www.proff.dk', $url, 'DK');

        //Sweden
        //20-49
        $url = 'https://www.proff.se/segmentering?numEmployeesFrom=20&numEmployeesTo=49';        
        (new CompanyService())->setup('https://www.proff.se', $url, 'SV');
        
        //159-249
        $url = 'https://www.proff.se/segmentering?numEmployeesFrom=159&numEmployeesTo=249';        
        (new CompanyService())->setup('https://www.proff.se', $url, 'SV');
        
        //Norway
        //20-49
        $url = 'https://www.proff.no/segmentering?numEmployeesFrom=20&numEmployeesTo=49';        
        (new CompanyService())->setup('https://www.proff.no', $url, 'NO');
        
        //159-249
        $url = 'https://www.proff.no/segmentering?numEmployeesFrom=159&numEmployeesTo=249';        
        (new CompanyService())->setup('https://www.proff.no', $url, 'NO');
        
        //Finland
        //20-49
        $url = 'https://www.proff.fi/segmentointi?employeeRange=20%20-%2049';        
        (new CompanyService())->setup('https://www.proff.fi', $url, 'FI');
        
        //159-249
        $url = 'https://www.proff.fi/segmentointi?employeeRange=100%20-%20249';        
        (new CompanyService())->setup('https://www.proff.fi', $url, 'FI');
        
        (new EmployeeCheckAction())->excecute();

        return response()->json();
   }

   //Fetch employee history for company
   public function fetchEmployeeHistoryForCompany(Company $company) {
        return $company->employeeHistory()->get();
   }
}