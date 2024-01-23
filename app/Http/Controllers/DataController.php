<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Municipality;
use App\Models\CompanyEmployee;
use App\Models\TriggerLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function companies(): JsonResponse
    {
        return response()->json(
            Company::all(),
        );
    }

    public function employees(): JsonResponse
    {
        return response()->json(
            CompanyEmployee::all(),
        );
    }

    public function municipalities(): JsonResponse
    {
        return response()->json(
            Municipality::all(),
        );
    }    

    public function triggerLeads(): JsonResponse
    {
        return response()->json(
            TriggerLead::all(),
        );
    }    
}
