<?php

use App\Http\Controllers\View\TriggerLeadsController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('trigger-leads')->group(function () {
  Route::get('/', [TriggerLeadsController::class, 'index']);
  Route::get('/{employees}/{year}/{month}', [TriggerLeadsController::class, 'show']);
  Route::delete('/remove', [TriggerLeadsController::class, 'remove']);
});

Route::get('/b-corporations', [ViewController::class, 'triggerLeads']);
