<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTenant;

use App\Http\Controllers\Web\Tenant\TenantDashboardController;
use App\Http\Controllers\Web\Tenant\TenantLeaseController;
use App\Http\Controllers\Web\Tenant\TenantPaymentController;
use App\Http\Controllers\Web\Tenant\TenantTicketController;
use App\Http\Controllers\Web\Tenant\TenantMessageController;
use App\Http\Controllers\Web\Tenant\TenantDocumentsController;

Route::middleware(['auth', EnsureTenant::class])
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function () {

        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

        Route::resource('leases', TenantLeaseController::class)->only(['index', 'show']);
        Route::resource('payments', TenantPaymentController::class)->only(['index', 'show']);
        Route::resource('tickets', TenantTicketController::class);
        Route::resource('messages', TenantMessageController::class);
        Route::resource('documents', TenantDocumentsController::class)->only(['index']);
    });
