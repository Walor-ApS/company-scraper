<?php

namespace App\Http\Controllers;

use App\Models\CompanyEmployee;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __invoke(Request $request)
    {
        $country = $request->get('country');

        $employees = CompanyEmployee::take(50)
            ->where('employees', '<', 50)
            ->where('employees', '>', 45)
            ->whereHas('company', function($q) use($country){
                $q->where('country', $country);
            })
            ->with('company')
            ->latest()
            ->get();

        return response()->json($employees);
    }
}