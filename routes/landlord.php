<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureLandlord;

use App\Http\Controllers\Web\Landlord\LandlordDashboardController;
use App\Http\Controllers\Web\Landlord\PropertyCrudController;
use App\Http\Controllers\Web\Landlord\UnitCrudController;
use App\Http\Controllers\Web\Landlord\LeaseCrudController;
use App\Http\Controllers\Web\Landlord\LandlordPaymentController;
use App\Http\Controllers\Web\Landlord\LandlordExpenseController;
use App\Http\Controllers\Web\Landlord\LandlordTenantController;
use App\Http\Controllers\Web\Landlord\LandlordMessageController;
use App\Http\Controllers\Web\Landlord\LandlordTicketController;
use App\Http\Controllers\Web\Landlord\LandlordTicketDashboardController;
use App\Http\Controllers\Web\Landlord\MaintenanceDashboardController;

Route::middleware(['auth', EnsureLandlord::class])
    ->prefix('landlord')
    ->name('landlord.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [LandlordDashboardController::class, 'index'])->name('dashboard');

        // Proprietà
        Route::resource('properties', PropertyCrudController::class);

        Route::get('/units/available', [\App\Http\Controllers\Web\Landlord\LandlordUnitController::class, 'available']) ->name('units.available');

        // Unità
        Route::prefix('properties/{property}/units')->name('units.')->group(function () {
            Route::get('/', [UnitCrudController::class, 'index'])->name('index');
            Route::get('/create', [UnitCrudController::class, 'create'])->name('create');
            Route::post('/', [UnitCrudController::class, 'store'])->name('store');
            Route::get('/{unit}/edit', [UnitCrudController::class, 'edit'])->name('edit');
            Route::put('/{unit}', [UnitCrudController::class, 'update'])->name('update');
            Route::delete('/{unit}', [UnitCrudController::class, 'destroy'])->name('destroy');
        });

        // Contratti
        Route::prefix('properties/{property}/leases')->name('leases.')->group(function () {
            Route::get('/', [LeaseCrudController::class, 'index'])->name('index');
            Route::get('/create', [LeaseCrudController::class, 'create'])->name('create');
            Route::post('/', [LeaseCrudController::class, 'store'])->name('store');
            Route::get('/{lease}/edit', [LeaseCrudController::class, 'edit'])->name('edit');
            Route::put('/{lease}', [LeaseCrudController::class, 'update'])->name('update');
            Route::delete('/{lease}', [LeaseCrudController::class, 'destroy'])->name('destroy');
        });

        // Pagamenti
        Route::resource('payments', LandlordPaymentController::class);

        // Spese
        Route::resource('expenses', LandlordExpenseController::class);

        // Inquilini
        Route::resource('tenants', LandlordTenantController::class);

        // Messaggi
        Route::resource('messages', LandlordMessageController::class);

        // Ticket
        Route::resource('tickets', LandlordTicketController::class);

        // Dashboard manutenzioni
        Route::get('/maintenance', [MaintenanceDashboardController::class, 'index'])->name('maintenance.dashboard');
        Route::get('/maintenance/dashboard', [LandlordTicketDashboardController::class, 'index'])->name('maintenance.tickets');
    });
