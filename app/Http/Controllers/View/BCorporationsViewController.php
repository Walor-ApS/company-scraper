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

    public function show(String $country) {
        $bcorporations = BCorporation::where('country', $country)->paginate(24);
        
        return view('bcorporations/show')->with([
            'bcorporations' => $bcorporations,
            'country' => $country
        ]);
    }

    public function update(Request $request) {
        (new UpdateCompanyService())->setup($request, new BCorporation());        
        
        return redirect()->back()->withInput(['refresh' => true]);
    }
}