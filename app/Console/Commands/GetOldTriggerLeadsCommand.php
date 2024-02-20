<?php

namespace App\Console\Commands;

use App\Models\Company;
use Illuminate\Console\Command;

class GetOldTriggerLeadsCommand extends Command
{
    protected $signature = 'trigger-leads:get-old';

    public function handle(): void
    {
        $companies = $this->getCompanies();

        logger($companies);
    }

    private function getCompanies(): array
    {
        $companies = Company::select(["id"])
            ->with("employeeHistory")
            ->get();

        $matchingCompanies = [];

        foreach ($companies as $company) {
            $hasBelow = $company
                ->employeeHistory()
                ->where("employees", "<", "50")
                ->exists();

            $hasAbove = $company
                ->employeeHistory()
                ->where("employees", ">", "49")
                ->exists();

            if ($hasBelow && $hasAbove) {
                $matchingCompanies[] = $company->id;
            }
        }

        return $matchingCompanies;
    }
}
