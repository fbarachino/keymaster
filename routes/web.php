<?php

use Illuminate\Support\Facades\Route;

// TENANT CONTROLLERS
use App\Http\Controllers\Web\Tenant\TenantDashboardController;
use App\Http\Controllers\Web\Tenant\TenantLeaseController;
use App\Http\Controllers\Web\Tenant\TenantPaymentController;
use App\Http\Controllers\Web\Tenant\TenantMessageController;
use App\Http\Controllers\Web\Tenant\TenantDocumentsController;
use App\Http\Controllers\Web\Tenant\TicketController as TenantTicketController;
use App\Http\Controllers\Web\Tenant\LeaseSignatureController;

// LANDLORD CONTROLLERS
use App\Http\Controllers\Web\Landlord\LandlordDashboardController;
use App\Http\Controllers\Web\Landlord\PropertyCrudController;
use App\Http\Controllers\Web\Landlord\UnitCrudController;
use App\Http\Controllers\Web\Landlord\LeaseCrudController;
use App\Http\Controllers\Web\Landlord\PaymentCrudController;
use App\Http\Controllers\Web\Landlord\LandlordMessageController;
use App\Http\Controllers\Web\Landlord\TenantManagementController;
use App\Http\Controllers\Web\Landlord\MaintenanceDashboardController;

// COMMON
use App\Http\Controllers\Web\MessagesController;
use App\Http\Controllers\Web\LeasePdfController;


// ---------------------------------------------------------
//  AREA AUTENTICATA
// ---------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // -----------------------------------------------------
    //  TENANT PORTAL
    // -----------------------------------------------------
    Route::middleware('tenant')->prefix('tenant')->group(function () {

        // Dashboard
        Route::get('dashboard', [TenantDashboardController::class, 'index'])
            ->name('tenant.dashboard');

        // Contratti
        Route::get('leases', [TenantLeaseController::class, 'index'])
            ->name('tenant.leases.index');

        Route::get('leases/{lease}', [TenantLeaseController::class, 'show'])
            ->name('tenant.leases.show');

        // Firma digitale contratto
        Route::get('leases/{lease}/sign', [LeaseSignatureController::class, 'showForm'])
            ->name('tenant.leases.sign.form');

        Route::post('leases/{lease}/sign', [LeaseSignatureController::class, 'sign'])
            ->name('tenant.leases.sign');

        // Pagamenti
        Route::get('payments', [TenantPaymentController::class, 'index'])
            ->name('tenant.payments.index');

        // Messaggi
        Route::resource('messages', TenantMessageController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Documenti unità
        Route::get('documents', [TenantDocumentsController::class, 'index'])
            ->name('tenant.documents.index');

        // Ticket manutenzione
        Route::resource('tickets', TenantTicketController::class)
            ->only(['index', 'create', 'store', 'show']);
    });


    // -----------------------------------------------------
    //  LANDLORD PORTAL
    // -----------------------------------------------------
    Route::middleware('landlord')->prefix('landlord')->group(function () {

        // Dashboard
        Route::get('dashboard', [LandlordDashboardController::class, 'index'])
            ->name('landlord.dashboard');

        // Proprietà
        Route::resource('properties', PropertyCrudController::class);

        // Unità
        Route::get('properties/{property}/units', [UnitCrudController::class, 'index'])
            ->name('landlord.units.index');

        Route::get('properties/{property}/units/create', [UnitCrudController::class, 'create'])
            ->name('landlord.units.create');

        Route::post('properties/{property}/units', [UnitCrudController::class, 'store'])
            ->name('landlord.units.store');

        Route::get('properties/{property}/units/{unit}/edit', [UnitCrudController::class, 'edit'])
            ->name('landlord.units.edit');

        Route::put('properties/{property}/units/{unit}', [UnitCrudController::class, 'update'])
            ->name('landlord.units.update');

        Route::delete('properties/{property}/units/{unit}', [UnitCrudController::class, 'destroy'])
            ->name('landlord.units.destroy');

        // Upload foto unità
        Route::post('properties/{property}/units/{unit}/photos',
            [UnitCrudController::class, 'uploadPhotos'])
            ->name('landlord.units.photos.upload');

        // Inventario unità
        Route::post('properties/{property}/units/{unit}/inventory',
            [UnitCrudController::class, 'addInventory'])
            ->name('landlord.units.inventory.add');

        // Documenti unità
        Route::post('properties/{property}/units/{unit}/documents',
            [UnitCrudController::class, 'uploadDocument'])
            ->name('landlord.units.documents.upload');

        // Contratti
        Route::resource('leases', LeaseCrudController::class)
            ->except(['show']);

        // Pagamenti
        Route::resource('payments', PaymentCrudController::class);

        // Messaggi
        Route::resource('messages', LandlordMessageController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Creazione inquilino + assegnazione contratto
        Route::get('tenants/create', [TenantManagementController::class, 'create'])
            ->name('landlord.tenants.create');

        Route::post('tenants', [TenantManagementController::class, 'store'])
            ->name('landlord.tenants.store');

        // Dashboard manutenzioni
        Route::get('maintenance', [MaintenanceDashboardController::class, 'index'])
            ->name('landlord.maintenance.dashboard');
    });


    // -----------------------------------------------------
    //  FUNZIONALITÀ COMUNI
    // -----------------------------------------------------

    // Messaggi globali tenant ↔ landlord
    Route::resource('messages', MessagesController::class)
        ->only(['index', 'create', 'store', 'show']);

    // PDF contratto
    Route::get('leases/{lease}/pdf', [LeasePdfController::class, 'downloadPdf'])
        ->name('leases.pdf');
});
