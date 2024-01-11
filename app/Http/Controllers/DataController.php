<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\Municipality;
use Illuminate\Http\JsonResponse;

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
}
