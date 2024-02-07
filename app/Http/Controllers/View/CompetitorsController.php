<?php

namespace App\Http\Controllers\View;

use App\Actions\CreateCompetitorCompany;
use Illuminate\Http\Request;
use App\Models\CompetitorCompany;
use App\Http\Controllers\Controller;
use App\Models\Competitor;
use App\Services\UpdateCompanyService;

class CompetitorsController extends Controller
{
    public function index() {
        $competitors = CompetitorCompany::all()->groupBy('competitor_id')->reverse();

        return view('competitors.index', [
            "competitors" => $competitors,
        ]);
    }

    public function show(Competitor $competitor, Request $request) {
        $companies = CompetitorCompany::where("competitor_id", $competitor->id);
        
        if ($request->search) {
            $companies->where("name", "LIKE", "%$request->search%");
        }

        return view('competitors.show', [
            "companiesCount" => count($companies->get()),
            "companies" => $companies->paginate(24),
            "competitor" => $competitor
        ]);
    }

    public function import(Request $request) {     
        if ($request->file && $request->competitor_name) {
            $fileName = $request->file->getClientOriginalName();
            $endPosition = strpos($fileName, '-backlinks');;
            $competitor = substr($fileName, 0, $endPosition);
    
            $companies = array_map('str_getcsv', file($request->file));
            $companies = array_slice($companies, 1);

            $companyTargetUrls = [];
            foreach ($companies as $company) {
                if (!in_array($company[13], $companyTargetUrls)) {
                    array_push($companyTargetUrls, $company[13]);

                    (new CreateCompetitorCompany())->excecute($company, $competitor, $request->competitor_name);
                }
            }
        }
        
        return redirect()->back()->withInput(['refresh' => true]);
    }

    public function update(Competitor $competitor, Request $request) {
        $companies = CompetitorCompany::where("competitor_id", $competitor->id)->get();

        $externalProperties = [
            "source_of_origin" => "Competitors",
            "wb_solution" => $competitor->name       
        ];

        (new UpdateCompanyService())->setup($request, $companies, $externalProperties);        
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}
