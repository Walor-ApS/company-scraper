<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class CompaniesController extends Controller
{
    private $company;

    public function index(): JsonResponse {
        $browser = new HttpBrowser(HttpClient::create());
        $website = $browser->request('GET', 'https://www.proff.dk/segmentering?mainUnit=true&numEmployeesFrom=20&numEmployeesTo=49');
        
        $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();        
        
        //Handle pagination
        for ($i = 1; $i <= 1; $i++) {
            $website = $browser->request('GET', "https://www.proff.dk/segmentering?mainUnit=true&numEmployeesFrom=20&numEmployeesTo=49&page=$i");
            $this->scrapeCompanies($website);
        }

        return response()->json();
   }

   public function scrapeCompanies($website) {
        $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) {            
            $link_href = $node->filter('div div h2 a')->attr('href');
            
            $browser = new HttpBrowser(HttpClient::create());
            $website = $browser->request('GET', "https://www.proff.dk$link_href");
            
            //Fetching the data
            //Fetch data from the two info boxes on the website
            $this->company = new Company();

            $website->filter('.MuiGrid-root.MuiGrid-container.MuiGrid-spacing-md-2.css-1tw4074')->each(function ($node) {                
                $node->filter('.MuiBox-root .OfficialCompanyInformationCard-propertyList')->each(function ($child) {
                    $this->fetchCompanyInformation($child);
                });
            });

            $this->company = Company::updateOrCreate([
                'name' => $this->company->name,
                'cvr' => $this->company->cvr,
                'founded_at' => $this->company->founded_at,
                'employees' => $this->company->employees,
                'address' => $this->company->address,
                'company_type' => $this->company->company_type,
                'phone' => $this->company->name,
            ]);
            $this->storeEmployeeHistory($this->company->cvr);
        });        
   }

   public function fetchCompanyInformation($node) {
        $fieldName = $node->filter('.OfficialCompanyInformationCard-property')->text();
        $fieldValue = $node->filter('.OfficialCompanyInformationCard-propertyValue')->text();                
        
        if ($fieldName == "Juridisk navn") {
            $this->company->name = $fieldValue;
        }  
        elseif ($fieldName == "CVR-nr") {
            $this->company->cvr = $fieldValue;
        }  
        elseif ($fieldName == "Startdato") {
            $this->company->founded_at = $fieldValue;
        }
        elseif ($fieldName == "Telefon") {
            $this->company->phone = $fieldValue;
        }  
        elseif ($fieldName == "Adresse") {
            $this->company->address = $fieldValue;
        }  
        elseif ($fieldName == "Selskabsform") {
            $this->company->company_type = $fieldValue;
        }  
        elseif ($fieldName == "Antal ansatte") {
            $this->company->employees = $fieldValue;
        }  
   }

   //Store employee history for company
   public function storeEmployeeHistory($cvr) {
        $response = Http::withHeaders([
            'Authorization' => 'cvr.dev_d1932811ecc4d5906d28c44d3a3fbdfb'
            ])->get("https://api.cvr.dev/api/cvr/virksomhed?cvr_nummer=$cvr");

        $jsonData = $response->json();

        if (! $jsonData) {
            return;
        }

        foreach ($jsonData[0]['maanedsbeskaeftigelse'] as $employeeHistory) {
            CompanyEmployee::updateOrCreate([
                'year' => $employeeHistory['aar'],
                'month' => $employeeHistory['maaned'],
                'employees' => $employeeHistory['antalAnsatte'],
                'company_id' => $this->company->id
            ]);
        }
   }

   //Fetch employee history for company
   public function fetchEmployeeHistoryForCompany(Company $company) {
        return $company->employeeHistory()->get();
   }
}