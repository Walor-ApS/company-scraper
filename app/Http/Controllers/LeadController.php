<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadCompanyEmployeeResource;
use App\Models\CompanyEmployee;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __invoke(Request $request)
    {
        $country = $request->get('country');

        $employeesTest = CompanyEmployee::select('company_id', 'employees')
            ->groupBy('company_id')
            ->selectRaw('COUNT(DISTINCT employees) as unique_counts')
            ->having('unique_counts', '>', 1)
            ->pluck('company_id');

        $employees = CompanyEmployee::whereIn('company_id', $employeesTest)
            ->take(50)
            ->where('employees', '<', 50)
            ->where('employees', '>', 44)
            ->whereHas('company', function($q) use($country){
                $q->where('country', $country);
            })
            ->with('company')
            ->latest()
            ->get();

        return LeadCompanyEmployeeResource::collection($employees);
    }
}
