<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\Municipality;
use App\Models\SlackChannel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class CompaniesController extends Controller
{
    private $company;

    public function index(): JsonResponse {
        $browser = new HttpBrowser(HttpClient::create());
        $url = 'https://www.proff.dk/segmentering?mainUnit=true&numEmployeesFrom=20&numEmployeesTo=49';
        $website = $browser->request('GET', $url);                

        $maxPages = $website->filter('nav .MuiPagination-ul')->children()->eq(7)->text();
        
        //Handle pagination
        for ($i = 1; $i <= $maxPages; $i++) {
            $website = $browser->request('GET', "$url&page=$i");
            $this->scrapeCompanies($website);
        }

        $this->checkCompaniesHasExceededEmployeeNumber(50);

        return response()->json();
   }

   //Check companies have exceeded employee number
   public function checkCompaniesHasExceededEmployeeNumber(Int $employee_number): void {
        $companies = Company::all();  
        
        foreach ($companies as $company) {
            $response = Http::withHeaders([
                'Authorization' => 'cvr.dev_d1932811ecc4d5906d28c44d3a3fbdfb'
                ])->get("https://api.cvr.dev/api/cvr/virksomhed?cvr_nummer=$company->cvr");
    
            $jsonData = $response->json()[0];

            $monthlyEmployeeHistory = $jsonData['erstMaanedsbeskaeftigelse'];
            $length = sizeof($monthlyEmployeeHistory) - 1;

            $lastMonthEmployees = $monthlyEmployeeHistory[$length - 1]['antalAnsatte'];
            $thisMonthEmployees = $monthlyEmployeeHistory[$length]['antalAnsatte'];

            if ($thisMonthEmployees > $employee_number && $lastMonthEmployees < $employee_number) {
                $company_phone_check = $company->phone == null ? "Unknown" : $company->phone;
                $company_email_check = $company->email == null ? "Unknown" : $company->email;
                $link = "https://www.proff.dk$company->link";

                SlackChannel::SlackNotify("
                🎉 NEW POTENTIAL CLIENT 🎉 \n
                - Name: $company->name\n
                - CVR: $company->cvr\n
                - Employees: $company->employees\n
                - Founded at: $company->founded_at\n
                - Address: $company->address\n
                - Company type: $company->company_type\n
                - Phone number: $company_phone_check\n
                - Email: $company_email_check\n
                - Adverising protected: $company->advertising_protected\n
                \nLearn more about the company here: $link
                ");
            }
        }
   }

   //Store companies
   public function scrapeCompanies($website): void {
        $website->filter('.MuiPaper-root .SegmentationSearchResultCard-card')->each(function ($node) {            
            $cvr = substr($node->filter('.CardHeader-propertyList.MuiBox-root.css-gf5as1')->text(), 6, 8);

            $response = Http::withHeaders([
                'Authorization' => 'cvr.dev_d1932811ecc4d5906d28c44d3a3fbdfb'
                ])->get("https://api.cvr.dev/api/cvr/virksomhed?cvr_nummer=$cvr");
    
            $jsonData = $response->json()[0];
    
            if (! $jsonData) {
                return response('JSON data was not found', 404);
            }
            
            //Address info
            $addressInfo = $jsonData['virksomhedMetadata']['nyesteBeliggenhedsadresse'];
            $country = $addressInfo['landekode'];
            $municipality = ucfirst(strtolower($addressInfo['kommune']['kommuneNavn']));
            $zip_code = $addressInfo['postnummer'];
            $city = $addressInfo['postdistrikt'];
            $street_name = $addressInfo['vejnavn'];
            $house_number = $addressInfo['husnummerFra'];
            $house_letter = $addressInfo['bogstavFra'];
            $address = "$street_name $house_number$house_letter, $zip_code $city";

            //Create municipality
            $municipality = Municipality::updateOrCreate([
                'name' => $municipality,
                'code' => $addressInfo['kommune']['kommuneKode']
            ]);

            $link = $node->filter('.MuiTypography-root.MuiTypography-inherit.MuiLink-root.MuiLink-underlineHover.css-105wgyd')->attr('href');

            $this->company = Company::updateOrCreate([
                'name' => $jsonData['virksomhedMetadata']['nyesteNavn']['navn'],
                'cvr' => $cvr,
                'founded_at' => $jsonData['virksomhedMetadata']['stiftelsesDato'],
                'employees' => $jsonData['virksomhedMetadata']['nyesteErstMaanedsbeskaeftigelse']['antalAnsatte'],
                'address' => $address,
                'zip_code' => $zip_code,
                'country' => $country,
                'city' => $city,
                'municipality_id' => $municipality->id,
                'phone' => $jsonData['telefonNummer'][0]['kontaktoplysning'] ?? null,
                'email' => $jsonData['elektroniskPost'][0]['kontaktoplysning'] ?? null,                
                'advertising_protected' => $jsonData['reklamebeskyttet'],
                'company_type' => $jsonData['virksomhedMetadata']['nyesteVirksomhedsform']['langBeskrivelse'],
                'link' => $link
            ]);

            $this->storeEmployeeHistory($jsonData);
        });
   }

   //Store employee history for company
   public function storeEmployeeHistory(Array $jsonData): void {        
        foreach ($jsonData['erstMaanedsbeskaeftigelse'] as $employeeHistory) {
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

//Action or service