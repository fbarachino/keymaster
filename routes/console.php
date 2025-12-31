<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerateMonthlyPayments;
// use App\Jobs\SendOverduePaymentNotifications;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(new GenerateMonthlyPayments)->monthly();
// Schedule::job(new SendOverduePaymentNotifications)->daily();
