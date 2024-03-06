<?php

use App\Http\Controllers\BCorporationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\oldLeadsController;
use Illuminate\Support\Facades\Artisan;

Route::get('companies', [CompaniesController::class, 'fetchCompanies']);
Route::get('employees', [CompaniesController::class, 'fetchEmployees']);
Route::get('companies/{company}/employees', [CompaniesController::class, 'fetchEmployeeHistoryForCompany']);

Route::prefix('data')->group(function () {
    Route::get('companies', [DataController::class, 'companies']);
    Route::get('employees', [DataController::class, 'employees']);
    Route::get('municipalities', [DataController::class, 'municipalities']);
    Route::get('triggerLeads', [DataController::class, 'triggerLeads']);
    Route::get('bcorporations', [DataController::class, 'bcorporations']);
});

Route::prefix('bcorporations')->group(function () {
    Route::get('companies', [BCorporationController::class, 'index']); //Call this endpoint to retrieve all B Corporations (You can't close down your computer)
});