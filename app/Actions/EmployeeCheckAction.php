<?php

namespace App\Actions;

use App\Models\Company;
use App\Models\SlackChannel;
use App\Models\TriggerLead;

class EmployeeCheckAction {
  public function excecute(Company $company): void {
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
      $newCompany->employees_range == "50 - 99" && $oldCompany->employees_range == "20 - 49"
      ||
      $newCompany->employees_range == "250 - 499" && $oldCompany->employees_range == "100 - 249"
      ) {

      $employeesCheck = $newCompany->employees == null ? $newCompany->employees : $newCompany->employees_range;
      $link = "https://www.proff.dk{$company->link}";

//      SlackChannel::SlackNotify("
//    🎉 NEW POTENTIAL CLIENT 🎉 \n
//        - Country {$company->country}
//        - Name: {$this->checkVariable($company->name)}\n
//        - CVR: {$this->checkVariable($company->cvr)}\n
//        - Employees: $employeesCheck\n
//        - Founded at: {$company->founded_at}\n
//        - Address: {$this->checkVariable($company->address)}\n
//        - Company type: {$this->checkVariable($company->company_type)}\n
//        - Phone number: {$this->checkVariable($company->phone)}\n
//        - Adverising protected: {$this->checkVariable($company->advertising_protected == true)}\n
//      \nLearn more about the company here: $link
//      ");

      $newCompanyEmployees = $newCompany->employees !== null ? $this->employeeRoundDown($newCompany->employees) : $this->employeeRangeRoundDown($newCompany->employees_range);
      TriggerLead::create([
        'company_id' => $company->id,
        'employees' => $newCompanyEmployees,
        'country' => $company->country,
        'year' => $company->created_at->format('Y'),
        'month' => $company->created_at->format('F')
      ]);
    }
  }

  function employeeRoundDown($number) {
    if ($number <= 250) {
        return floor($number / 50) * 50;
    } else {
        return floor($number / 250) * 250;
    }
  }

  function employeeRangeRoundDown($range) {
    if ($range == "50 - 99") {
        return 50;
    } else {
        return 250;
    }
  }

  public function checkVariable($var): String {
    if ($var == null) {
      return "Unknown";
    }
    return $var;
  }
}
