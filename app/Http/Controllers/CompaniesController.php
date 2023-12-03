<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        
        for ($i = 1; $i <= $maxPages; $i++) {
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

            Company::updateOrCreate([
                'name' => $this->company->name,
                'cvr' => $this->company->cvr,
                'founded_at' => $this->company->founded_at,
                'employees' => $this->company->employees,
                'address' => $this->company->address,
                'company_type' => $this->company->company_type,
                'phone' => $this->company->name,
            ]);
        });        
   }

   public function fetchCompanyInformation($node) {
        $fieldName = $node->filter('.OfficialCompanyInformationCard-property')->text();
        $fieldValue = $node->filter('.OfficialCompanyInformationCard-propertyValue')->text();                
        
        if ($fieldName == "Juridisk navn") {
            // echo $fieldValue;
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
}