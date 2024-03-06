<?php

namespace App\Console\Commands;

use App\Actions\EmployeeCheckAction;
use App\Models\Company;
use App\Models\TriggerLead;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class GetOldTriggerLeadsCommand extends Command
{
    protected $signature = 'trigger-leads:get-old';
    public $targetEmployees = 250;

    public function handle(): void
    {
        $companies = $this->getCompanies();

        foreach($companies as $company) {
            //Find the excact time where a company extended the target employees
            $companyTriggerPoint = $company->employeeHistory->reverse()->firstWhere('employees', '>=', $this->targetEmployees);

            TriggerLead::create([
                'company_id' => $company->id,
                'employees' => "$this->targetEmployees",
                'country' => $company->country,
                'year' => $companyTriggerPoint->year,
                'month' => $companyTriggerPoint->month
            ]);
        }
    }

    private function getCompanies(): Collection
    {
        $companies = Company::select(["id"])
            ->with("employeeHistory")
            ->get();

        $matchingCompanies = [];

        foreach ($companies as $company) {
            $hasBelow = $company
                ->employeeHistory()
                ->where("employees", "<", "$this->targetEmployees")
                ->exists();

            $hasAbove = $company
                ->employeeHistory()
                ->where("employees", ">=", "$this->targetEmployees")
                ->exists();

            if ($hasBelow && $hasAbove) {
                $matchingCompanies[] = $company->id;
            }
        }

        return Company::whereIn('id', $matchingCompanies)->get();
    }
}
