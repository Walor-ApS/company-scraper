<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

Route::get('companies', [CompaniesController::class, 'fetchCompanies']);
Route::get('employees', [CompaniesController::class, 'fetchEmployees']);
Route::get('companies/{company}/employees', [CompaniesController::class, 'fetchEmployeeHistoryForCompany']);

Route::prefix('data')->group(function () {
    Route::get('companies', [DataController::class, 'companies']);
    Route::get('employees', [DataController::class, 'employees']);
    Route::get('municipalities', [DataController::class, 'municipalities']);
    Route::get('triggerLeads', [DataController::class, 'triggerLeads']);
});