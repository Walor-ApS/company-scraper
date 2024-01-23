<?php

namespace App\Http\Controllers\View;

use App\Models\Company;
use App\Models\TriggerLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

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

    public function remove(Request $request) {
        $selectedCompanies = $request->input('selected_companies', []);
        foreach ($selectedCompanies as $key => $companyId) {
            $company = Company::find($companyId);
            $company->delete();
        }
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}
