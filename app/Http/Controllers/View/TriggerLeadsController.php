<?php

namespace App\Http\Controllers\View;

use App\Models\Company;
use App\Models\TriggerLead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TriggerLeadsController extends Controller
{
    public function index() {
        $triggerLeads = TriggerLead::all()->sortBy(['employees', 'created_at'])->groupBy(['year', 'employees', 'month', 'country']);        
        $years = TriggerLead::select('year')->distinct()->orderBy('year')->get()->pluck('year');

        return view('trigger-leads/index')->with([
            "currentPage" => "Trigger Leads", 
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
            "currentPage" => "Trigger Leads",
            "month" => $month,
            "triggerLeads" => $triggerLeads
        ]);
    }

    public function update(Request $request) {        
        $websites = $request->input('websites', []);
        $companyIds = $request->input('companyIds', []);

        foreach ($websites as $key => $website) {
            if ($website != null) {
                $company = Company::find($companyIds[$key]);
                $company->update([
                    'link' => $website
                ]);
            }
        }

        $selectedCompanies = $request->input('selected_companies');
        if ($selectedCompanies) {
            foreach ($selectedCompanies as $key => $companyId) {
                $company = Company::find($companyId);
                
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('HUB_SPOT_ACCESS_TOKEN'),
                    'Content-Type' => 'application/json',
                ])->post("https://api.hubapi.com/crm/v3/objects/companies", [
                    'properties' => [
                        "country" => $company->country,
                        "name" => $company->name,
                        "phone" => $company->phone,
                        "domain" => $company->link
                    ]
                ]);

                $company->update([
                    "state" => "Imported"
                ]);
            }
        }
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}