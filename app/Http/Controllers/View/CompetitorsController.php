<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;
use App\Models\CompetitorCompany;
use App\Http\Controllers\Controller;
use App\Services\UpdateCompanyService;

class CompetitorsController extends Controller
{
    public function index() {
        $competitors = CompetitorCompany::all()->groupBy('competitor');

        return view('competitors.index', [
            "competitors" => $competitors,
        ]);
    }

    public function show(String $competitor) {
        $companies = CompetitorCompany::where("competitor", $competitor)->paginate(24);        

        return view('competitors.show', [
            "companies" => $companies,
            "competitor" => $competitor
        ]);
    }

    public function import(Request $request) {  
        $fileName = $request->file->getClientOriginalName();
        $endPosition = strpos($fileName, '-backlinks');;
        $competitorName = substr($fileName, 0, $endPosition);

        $companies = array_map('str_getcsv', file($request->file));
        $companies = array_slice($companies, 1);

        foreach ($companies as $company) {     
            CompetitorCompany::updateOrCreate([
                'name' => $company[0],
                'page_url' => $company[1],
                'competitor' => $competitorName
            ]);
        }
        
        return redirect()->back()->withInput(['refresh' => true]);
    }

    public function update(Request $request) {
        (new UpdateCompanyService())->setup($request, new CompetitorCompany());        
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}
