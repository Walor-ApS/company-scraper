<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\View\TriggerLeadsController;
use App\Http\Controllers\View\BCorporationsViewController;
use App\Http\Controllers\View\CompetitorsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ViewController::class, 'index']);

Route::prefix('triggerLeads')->group(function () {
  Route::get('/', [TriggerLeadsController::class, 'index']);
  Route::get('/{employees}/{year}/{month}', [TriggerLeadsController::class, 'show']);
  Route::put('/{employees}/{year}/{month}/{country}/update', [TriggerLeadsController::class, 'update']);  
});

Route::prefix('bcorporations')->group(function () {
  Route::get('/', [BCorporationsViewController::class, 'index']);
  Route::get('/{country}', [BCorporationsViewController::class, 'show']);
  Route::put('/{country}/update', [BCorporationsViewController::class, 'update']);  
});

Route::prefix('competitors')->group(function () {
  Route::get('/', [CompetitorsController::class, 'index']);
  Route::post('/import', [CompetitorsController::class, 'import']);
  Route::get('/{competitor}', [CompetitorsController::class, 'show']);
  Route::put('/{competitor}/update', [CompetitorsController::class, 'update']);
});
