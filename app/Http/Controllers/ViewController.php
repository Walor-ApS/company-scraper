<?php

namespace App\Http\Controllers;

use App\Models\TriggerLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index() {
        return redirect('/triggerLeads');
    }
}
