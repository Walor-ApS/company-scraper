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

    public function handle(): void
    {
        $companies = $this->getCompanies();

       foreach($companies as $company) {
           (new EmployeeCheckAction())->excecute($company);
//           $newCompanyEmployees = $company
//               ->employeeHistory()
//               ->where("employees", ">", "49")
//               ->first()
//               ->employees;
//
//           $newCompanyEmployeesCount = $newCompanyEmployees !== null ? $this->employeeRoundDown($company->employees) : $this->employeeRangeRoundDown($company->employees_range);
//
//
//           TriggerLead::create([
//               'company_id' => $company->id,
//               'employees' => $newCompanyEmployeesCount,
//               'country' => $company->country,
//               'year' => $company->created_at->format('Y'),
//               'month' => $company->created_at->format('F')
//           ]);
       }
    }

    private function getCompanies(): Collection
    {
        return Company::all();
//        $companies = Company::select(["id"])
//            ->with("employeeHistory")
//            ->get();
//
//        $matchingCompanies = [];
//
//        foreach ($companies as $company) {
//            $hasBelow = $company
//                ->employeeHistory()
//                ->where("employees", "<", "50")
//                ->exists();
//
//            $hasAbove = $company
//                ->employeeHistory()
//                ->where("employees", ">", "49")
//                ->exists();
//
//            if ($hasBelow && $hasAbove) {
//                $matchingCompanies[] = $company->id;
//            }
//        }
//
//        return Company::whereIn('id', $matchingCompanies)->get();
    }
}
