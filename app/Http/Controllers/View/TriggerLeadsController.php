<?php

namespace App\Http\Controllers\View;

use App\Models\Company;
use App\Models\TriggerLead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UpdateCompanyService;

class TriggerLeadsController extends Controller
{
    public function index() {
        $triggerLeads = TriggerLead::all()->sortBy(['employees', 'created_at'])->groupBy(['year', 'employees', 'month', 'country']);        
        $years = TriggerLead::select('year')->distinct()->orderBy('year')->get()->pluck('year');

        return view('trigger-leads/index')->with([            
            "years" => $years, 
            "triggerLeads" => $triggerLeads
        ]);
    }
    
    public function show(String $employees, String $year, String $month) {
        $triggerLeads = TriggerLead::where(['year' => $year, 'month' => $month, 'employees' => $employees])->get()->groupBy('country');

        // Fetch company information for each trigger lead
        foreach ($triggerLeads as $country => $leads) {
            foreach ($leads as $lead) {
                $company = Company::find($lead->company_id);
                $companyEmployees = $company->employeeHistory()->first();
                $lead->company = $company;
                $lead->employees = $companyEmployees->employees ?? $companyEmployees->employees_range;
            }
        }

        return view('trigger-leads/show')->with([
            "month" => $month,
            "triggerLeads" => $triggerLeads
        ]);
    }

    public function update(String $employees, String $year, String $month, String $country, Request $request) {
        $triggerLeads = TriggerLead::where(['year' => $year, 'month' => $month, 'employees' => $employees]);
        if ($country != "all") {
            $triggerLeads->where("country", $country);
        }
        $companyIds = $triggerLeads->get()->pluck('company_id');

        $companies = Company::whereIn('id', $companyIds)->get();

        
        (new UpdateCompanyService())->setup($request, $companies);
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}