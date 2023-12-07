<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\SlackChannel;
use App\Models\CompanyEmployee;
use Illuminate\Support\Facades\Http;

class CompanyService {
  //Check companies have exceeded employee number
  public function checkCompaniesHasExceededEmployeeNumber(): void {
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

          if ($thisMonthEmployees > 50 && $lastMonthEmployees < 50 || $thisMonthEmployees > 250 && $lastMonthEmployees < 250) {    
            $monthsBetweenDates = Carbon::now()->diffInMonths($company->noticed_at);
            if ($monthsBetweenDates >= 3) {
                $companyPhoneCheck = $company->phone == null ? "Unknown" : $company->phone;
                $companyEmailCheck = $company->email == null ? "Unknown" : $company->email;
                $link = "https://www.proff.dk$company->link";
    
                SlackChannel::SlackNotify("
                🎉 NEW POTENTIAL CLIENT 🎉 \n
                - Name: $company->name\n
                - CVR: $company->cvr\n
                - Employees: $company->employees\n
                - Founded at: $company->founded_at\n
                - Address: $company->address\n
                - Company type: $company->company_type\n
                - Phone number: $companyPhoneCheck\n
                - Email: $companyEmailCheck\n
                - Adverising protected: $company->advertising_protected\n
                \nLearn more about the company here: $link
                ");
    
                $company->update([
                    'noticed_at' => Carbon::now()
                ]);
            }                  
          }
      }
  }

  //Store employee history for company
  public function storeEmployeeHistory(Array $jsonData, Company $company): void {        
    foreach ($jsonData['erstMaanedsbeskaeftigelse'] as $employeeHistory) {
        CompanyEmployee::updateOrCreate([
            'year' => $employeeHistory['aar'],
            'month' => $employeeHistory['maaned'],
            'employees' => $employeeHistory['antalAnsatte'],
            'company_id' => $company->id
        ]);
    }
  }
}