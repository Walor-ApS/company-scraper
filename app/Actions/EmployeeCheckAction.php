<?php

namespace App\Actions;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\SlackChannel;

class EmployeeCheckAction {
  public function excecute(): void {
    $companies = Company::all();

    foreach($companies as $company) {
      $employee_history = $company->employeeHistory()->get();
      $newCompany = $employee_history->first();
      $oldCompany = $employee_history->skip(1)->first();
      
      if (! $newCompany || ! $oldCompany) {
        return;
      };
      
      if (
        $newCompany->employees > 50 && $oldCompany->employees < 50 
        || 
        $newCompany->employees > 250 && $oldCompany->employees < 250
        ||
        $newCompany->employees_range == "50-99" && $oldCompany->employees_range == "20-49" 
        || 
        $newCompany->employees_range == "250-499" && $oldCompany->employees_range == "100-249"
        ) {
        $monthsBetweenDates = Carbon::now()->diffInMonths($company->noticed_at);
        if ($monthsBetweenDates >= 3 || !$company->noticed_at) {
          $employeesCheck = $newCompany->employees == null ? $newCompany->employees : $newCompany->employees_range;
          $link = "https://www.proff.dk{$company->link}";
          
          SlackChannel::SlackNotify("
          🎉 NEW POTENTIAL CLIENT 🎉 \n
              - Country {$company->country}
              - Name: {$this->checkVariable($company->name)}\n
              - CVR: {$this->checkVariable($company->cvr)}\n
              - Employees: $employeesCheck\n
              - Founded at: {$this->checkVariable($company->founded_at)}\n
              - Address: {$this->checkVariable($company->address)}\n
              - Company type: {$this->checkVariable($company->company_type)}\n
              - Phone number: {$this->checkVariable($$company->phone)}\n
              - Adverising protected: {$this->checkVariable($company->advertising_protected == true)}\n              
          \nLearn more about the company here: $link
          ");
        }                  
      }
    }
  } 
  
  public function checkVariable(String $var): String {
    if ($var == null) {
      return "Unknown";
    }
    return $var;
  }
}