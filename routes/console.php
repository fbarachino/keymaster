<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateMonthlyPayments;
// use App\Jobs\SendOverduePaymentNotifications;
use App\Console\Commands\GenerateMonthlyExpenseReports;
use App\Console\Commands\GenerateYearlySettlement;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new GenerateMonthlyPayments)->monthly();
Schedule::command('reports:yearly-settlement')->yearlyOn(1, 0, 0);
// Schedule::job(new SendOverduePaymentNotifications)->daily();
Schedule::command('reports:monthly-expenses')->monthly();
