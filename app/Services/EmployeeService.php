<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Actions\TranslateIconNames;
use App\Actions\EmployeeCheckAction;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class EmployeeService {
  private $company;
  private $translatedWords;
  private $browser;

  public function setup(): void {
    $companies = Company::all();

    foreach($companies as $company) {
      $this->company = $company;
      $this->translatedWords = (new TranslateIconNames())->index($this->company->country);
      $this->browser = new HttpBrowser(HttpClient::create());
      $url = $this->translatedWords['company_url'] . "/" . str_replace(" ", "", str_replace("-", "",$this->company->cvr . " "));

      if ($this->company->country == "FI") {
        $url = $this->translatedWords['company_url'] . "/" . $this->company->cvr;
      }

      $website = $this->browser->request('GET', $url);
      $website->filter('.MuiBox-root .MuiBox-root .MuiGrid-root div')->each(function ($node) {
        $node->filter('.MuiBox-root .OfficialCompanyInformationCard-propertyList')->each(function ($child) {
          $fieldName = $child->filter('.OfficialCompanyInformationCard-property')->text();
          $fieldValue = $child->filter('.OfficialCompanyInformationCard-propertyValue')->text();

          if ($fieldName == $this->translatedWords['employees']) {
            if (str_contains($fieldValue, '-')) {
              $this->company->employees_range = trim($fieldValue);
              return;
            }
            $this->company->employees = $fieldValue;
          }
        });
      });

      CompanyEmployee::create([
        'company_id' => $this->company->id,
        'year' => Carbon::now()->year,
        'month' => Carbon::now()->month,
        'week' => Carbon::now()->weekNumberInMonth,
        'employees' => $this->company->employees,
        'employees_range' => $this->company->employees_range
      ]);

      (new EmployeeCheckAction())->excecute($this->company);
    }
  }
}
