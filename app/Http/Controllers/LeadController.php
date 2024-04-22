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

        $employeesTest = CompanyEmployee::select('company_id', 'employee_count')
            ->groupBy('company_id')
            ->havingRaw('COUNT(DISTINCT employee_count) > 1')
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
