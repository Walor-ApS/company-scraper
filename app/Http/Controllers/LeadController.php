<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadCompanyEmployeeResource;
use App\Models\CompanyEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    public function __invoke(Request $request)
    {
        $country = $request->get('country');

        $employeesTest = CompanyEmployee::with('company')->groupBy(['employees', 'company_id'])
            ->havingRaw('COUNT(*) = 1')
            ->pluck('id');



        $employees = CompanyEmployee::whereIn('company_id', $employeesTest)
            ->take(50)
            ->where('employees', '<', 50)
            ->whereHas('company', function($q) use($country){
                $q->where('country', $country);
            })
            ->with('company')
            ->latest()
            ->get();

        return LeadCompanyEmployeeResource::collection($employees);
    }
}
