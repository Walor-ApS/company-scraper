<?php

namespace App\Http\Controllers\View;

use App\Models\BCorporation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UpdateCompanyService;

class BCorporationsViewController extends Controller
{
    public function index(Request $request) {
        $bcorporations = BCorporation::all()->groupBy('country')->sortByDesc->count();

        if ($request->search) {
            $bcorporations = $bcorporations->filter(function ($value, $key) use ($request) {
                return str_contains($key, $request->search);
            });;
        }

        return view('bcorporations/index')->with([
            'bcorporations' => $bcorporations            
        ]);
    }

    public function show(String $country, Request $request) {
        $bcorporations = BCorporation::where('country', $country);

        if ($request->search) {
            $bcorporations->where("name", "LIKE", "%$request->search%");
        }
        
        return view('bcorporations/show')->with([
            'bcorporationsCount' => count($bcorporations->get()),
            'bcorporations' => $bcorporations->paginate(24),
            'country' => $country,
        ]);
    }

    public function update(String $country, Request $request) {
        $bcorporations = BCorporation::where('country', $country)->get();
        (new UpdateCompanyService())->setup($request, $bcorporations);
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}