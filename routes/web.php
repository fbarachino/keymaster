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
use App\Http\Middleware\EnsureTenant;;
use App\Http\Middleware\EnsureLandlord;
use App\Http\Controllers\HomeController;



Route::get('/', function () { return view('welcome'); }); // oppure 'landing', se hai una view dedicata })->name('home');
Auth::routes(['register' => true]); // Production only (true)
Route::get('/home', [HomeController::class,'index'])->name('home'); // Development only (remove in production)



// ---------------------------------------------------------
//  AREA AUTENTICATA
// ---------------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // -----------------------------------------------------
    //  TENANT PORTAL
    // -----------------------------------------------------
    Route::middleware(EnsureTenant::class)->prefix('tenant')->name('tenant.')->group(function () {

        // Dashboard
        Route::get('dashboard', [TenantDashboardController::class, 'index'])
            ->name('dashboard');

        // Contratti
        Route::get('leases', [TenantLeaseController::class, 'index'])
            ->name('leases.index');

        Route::get('leases/{lease}', [TenantLeaseController::class, 'show'])
            ->name('leases.show');

        // Firma digitale contratto
        Route::get('leases/{lease}/sign', [LeaseSignatureController::class, 'showForm'])
            ->name('leases.sign.form');

        Route::post('leases/{lease}/sign', [LeaseSignatureController::class, 'sign'])
            ->name('leases.sign');

        // Pagamenti
        Route::get('payments', [TenantPaymentController::class, 'index'])
            ->name('payments.index');

        // Messaggi
        Route::resource('messages', TenantMessageController::class)
            ->only(['index', 'create', 'store', 'show']);

        // Documenti unità
        Route::get('documents', [TenantDocumentsController::class, 'index'])
            ->name('documents.index');

        // Ticket manutenzione
        Route::resource('tickets', TenantTicketController::class)
            ->only(['index', 'create', 'store', 'show']);
    });


    // -----------------------------------------------------
    //  LANDLORD PORTAL
    // -----------------------------------------------------
    Route::middleware(EnsureLandlord::class)->prefix('landlord')->name('landlord.')->group(function () {

        // Dashboard
        Route::get('dashboard', [LandlordDashboardController::class, 'index'])
            ->name('dashboard');

        // Proprietà
        Route::resource('properties', PropertyCrudController::class);

        // Unità
        Route::get('properties/{property}/units', [UnitCrudController::class, 'index'])
            ->name('units.index');

        Route::get('properties/{property}/units/create', [UnitCrudController::class, 'create'])
            ->name('units.create');

        Route::post('properties/{property}/units', [UnitCrudController::class, 'store'])
            ->name('units.store');

        Route::get('properties/{property}/units/{unit}/edit', [UnitCrudController::class, 'edit'])
            ->name('units.edit');

        Route::put('properties/{property}/units/{unit}', [UnitCrudController::class, 'update'])
            ->name('units.update');

        Route::delete('properties/{property}/units/{unit}', [UnitCrudController::class, 'destroy'])
            ->name('units.destroy');

        // Upload foto unità
        Route::post('properties/{property}/units/{unit}/photos',
            [UnitCrudController::class, 'uploadPhotos'])
            ->name('units.photos.upload');

        // Inventario unità
        Route::post('properties/{property}/units/{unit}/inventory',
            [UnitCrudController::class, 'addInventory'])
            ->name('units.inventory.add');

        // Documenti unità
        Route::post('properties/{property}/units/{unit}/documents',
            [UnitCrudController::class, 'uploadDocument'])
            ->name('units.documents.upload');

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
            ->name('tenants.create');

        Route::post('tenants', [TenantManagementController::class, 'store'])
            ->name('tenants.store');

        // Dashboard manutenzioni
        Route::get('maintenance', [MaintenanceDashboardController::class, 'index'])
            ->name('maintenance.dashboard');
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
})
// ---------------------------------------------------------
//  FINE AREA AUTENTICATA
;

