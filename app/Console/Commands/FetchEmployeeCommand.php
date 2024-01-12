<?php

namespace App\Console\Commands;

use App\Services\EmployeeService;
use Illuminate\Console\Command;

class FetchEmployeeCommand extends Command
{

    protected $signature = 'fetch-employees';

    public function handle(): void
    {
        logger()->info('fetchEmployees ran on schedule');

        (new EmployeeService())->setup();
    }
}
