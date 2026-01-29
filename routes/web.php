<?php

use App\Http\Middleware\EnsureAdmin;

// TENANT CONTROLLERS
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTenant;;
use App\Http\Middleware\EnsureLandlord;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Web\LeasePdfController;
use App\Http\Controllers\Web\MessagesController;

use App\Http\Controllers\Web\Tenant\TicketController;

// LANDLORD CONTROLLERS
use App\Http\Controllers\Landlord\UnitReportController;
use App\Http\Controllers\Web\Landlord\UnitCrudController;
use App\Http\Controllers\Web\Landlord\LeaseCrudController;
use App\Http\Controllers\Web\Tenant\TenantLeaseController;
use App\Http\Controllers\Web\Tenant\TenantTicketController;
use App\Http\Controllers\Web\Landlord\PaymentCrudController;
use App\Http\Controllers\Web\Tenant\TenantMessageController;
use App\Http\Controllers\Web\Tenant\TenantPaymentController;
use App\Http\Controllers\Web\Landlord\PropertyCrudController;
use App\Http\Controllers\Web\Tenant\LeaseSignatureController;
use App\Http\Controllers\Web\Tenant\TenantDashboardController;
use App\Http\Controllers\Web\Tenant\TenantDocumentsController;

// COMMON
use App\Http\Controllers\Web\Landlord\LandlordTenantController;
use App\Http\Controllers\Web\Landlord\LandlordTicketController;
use App\Http\Controllers\Web\Landlord\LandlordMessageController;
use App\Http\Controllers\Web\Landlord\LandlordPaymentController;
use App\Http\Controllers\Web\Landlord\TenantManagementController;
use App\Http\Controllers\Web\Landlord\LandlordDashboardController;
use App\Http\Controllers\Web\Landlord\MaintenanceDashboardController;
use App\Http\Controllers\Web\Landlord\LandlordTicketDashboardController;



Route::get('/', function () { return view('welcome'); }); // oppure 'landing', se hai una view dedicata })->name('home');
Auth::routes(['register' => true]); // Production only (true)
Auth::routes(['verify' => false]);

Route::get('/home', [HomeController::class,'index'])->name('home'); // Development only (remove in production)



// ---------------------------------------------------------
//  AREA AUTENTICATA
// ---------------------------------------------------------
Route::middleware(['auth'])->group(function ()
 {

    Route::middleware(EnsureAdmin::class)->prefix('admin')->name('admin.')->group(function () {
        Route::resource('landlords', \App\Http\Controllers\Admin\LandlordController::class);
        Route::get('profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editPassword'])->name('password.edit');
        Route::post('profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('password.update');
    });

    // -----------------------------------------------------
    //  TENANT PORTAL
    // -----------------------------------------------------
    Route::middleware(EnsureTenant::class)->prefix('tenant')->name('tenant.')->group(function () {

        // Ticket
        Route::get('/tickets', [TenantTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TenantTicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TenantTicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TenantTicketController::class, 'show'])->name('tickets.show');

        // Messaggi
        Route::resource('messages', TenantMessageController::class)->only(['index', 'create', 'store',]);
        Route::get('/messages/{thread}', [TenantMessageController::class, 'show']) ->name('messages.show');
        Route::get('/messages/create', [TenantMessageController::class, 'create'])->name('messages.create');
        Route::post('/messages/{thread}/reply', [TenantMessageController::class, 'reply'])->name('messages.reply');

        // Dashboard
        Route::get('dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

        // Contratti
        Route::get('leases', [TenantLeaseController::class, 'index'])->name('leases.index');

        // Report annuale conguaglio spese
        Route::get('yearly-reports', [\App\Http\Controllers\Web\Tenant\YearlyReportController::class, 'index']) ->name('yearly-reports.index');
        Route::get('yearly-reports/{report}/download', [\App\Http\Controllers\Web\Tenant\YearlyReportController::class, 'download']) ->name('yearly-reports.download');

        Route::get('leases/{lease}', [TenantLeaseController::class, 'show'])->name('leases.show');

        // Firma digitale contratto
        Route::get('leases/{lease}/sign', [LeaseSignatureController::class, 'showForm'])->name('leases.sign.form');

        Route::post('leases/{lease}/sign', [LeaseSignatureController::class, 'sign'])->name('leases.sign');

        // Pagamenti
        Route::get('payments', [TenantPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [TenantPaymentController::class, 'show']) ->name('payments.show');
        Route::get('payments/{payment}/receipt', [TenantPaymentController::class, 'receipt'] )->name('payments.receipt');

        // Documenti unità
        Route::get('documents', [TenantDocumentsController::class, 'index'])->name('documents.index');

        Route::get('/leases/{lease}/pdf', [\App\Http\Controllers\Web\Tenant\TenantLeasePdfController::class, 'show']) ->name('leases.pdf');

        // Ticket manutenzione
        Route::resource('tickets', TenantTicketController::class)->only(['index', 'create', 'store', 'show']);

        // Signature Leases
        Route::get('/tenant/leases/{lease}/sign', [\App\Http\Controllers\Web\Tenant\TenantLeaseSignController::class, 'show']) ->name('leases.sign.show');
        Route::post('/tenant/leases/{lease}/sign', [\App\Http\Controllers\Web\Tenant\TenantLeaseSignController::class, 'sign']) ->name('leases.sign.perform');
    });


    // -----------------------------------------------------
    //  LANDLORD PORTAL
    // -----------------------------------------------------
    Route::middleware(EnsureLandlord::class)->prefix('landlord')->name('landlord.')->group(function () {

        // Dashboard manutenzioni
        Route::get('/maintenance/dashboard', [LandlordTicketDashboardController::class, 'index']) ->name('maintenance.dashboard');

        // Ticket
        Route::get('/tickets', [LandlordTicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [LandlordTicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/status', [LandlordTicketController::class, 'updateStatus'])->name('tickets.status');
        Route::post('/tickets/{ticket}/notes', [LandlordTicketController::class, 'addNote'])->name('tickets.notes');

         /*Route::get('/messages/create', [LandlordMessageController::class, 'create']) ->name('messages.create');
         Route::post('/messages', [LandlordMessageController::class, 'store']) ->name('messages.store');
         Route::get('/messages', [LandlordMessageController::class, 'index']) ->name('messages.index');
         Route::get('/messages/{message}', [LandlordMessageController::class, 'show']) ->name('messages.show');*/

        // Messaggi
        Route::resource('messages', LandlordMessageController::class)->only(['index']);
        Route::get('/messages/create', [LandlordMessageController::class, 'create'])->name('messages.create');
        Route::post('/messages', [LandlordMessageController::class, 'store'])->name('messages.store');
        Route::get('/messages/{thread}', [LandlordMessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{thread}/reply', [LandlordMessageController::class, 'reply'])->name('messages.reply');

        // Dashboard
        Route::get('dashboard', [LandlordDashboardController::class, 'index'])->name('dashboard');

        // Proprietà
        Route::resource('properties', PropertyCrudController::class);

        // Unità
        Route::get('properties/{property}/units', [UnitCrudController::class, 'index'])->name('units.index');
        Route::get('properties/{property}/units/create', [UnitCrudController::class, 'create'])->name('units.create');
        Route::post('properties/{property}/units', [UnitCrudController::class, 'store'])->name('units.store');
        Route::get('properties/{property}/units/{unit}/edit', [UnitCrudController::class, 'edit'])->name('units.edit');
        Route::put('properties/{property}/units/{unit}', [UnitCrudController::class, 'update'])->name('units.update');
        Route::delete('properties/{property}/units/{unit}', [UnitCrudController::class, 'destroy'])->name('units.destroy');
        Route::get('/units/available', [\App\Http\Controllers\Web\Landlord\LandlordUnitController::class, 'available']) ->name('units.available');
        Route::get('units/{unit}/report', [UnitReportController::class, 'show']) ->name('units.report');
        Route::get('units/{unit}/report/pdf', [UnitReportController::class, 'pdf']) ->name('units.report.pdf');

        // Upload foto unità
        Route::post('properties/{property}/units/{unit}/photos',[UnitCrudController::class, 'uploadPhotos'])->name('units.photos.upload');

        // Inventario unità
        Route::post('properties/{property}/units/{unit}/inventory',[UnitCrudController::class, 'addInventory'])->name('units.inventory.add');

        // Documenti unità
        Route::post('properties/{property}/units/{unit}/documents',[UnitCrudController::class, 'uploadDocument'])->name('units.documents.upload');

        // Contratti
        Route::resource('/leases', LeaseCrudController::class)->except(['show']);

        // Pagamenti
        // Route::resource('payments', PaymentCrudController::class);
        Route::get('/payments', [LandlordPaymentController::class, 'index']) ->name('payments.index');
        Route::get('/payments/create', [LandlordPaymentController::class, 'create']) ->name('payments.create');
        Route::post('/payments', [LandlordPaymentController::class, 'store']) ->name('payments.store');
        Route::get('/landlord/payments/{payment}/receipt', [LandlordPaymentController::class, 'receipt'])->name('payments.receipt');
        Route::patch('payments/{payment}/mark-paid', [LandlordPaymentController::class, 'markPaid'] )->name('payments.markPaid');
        Route::get('payments/{payment}/edit', [LandlordPaymentController::class, 'edit']) ->name('payments.edit');
        Route::put('payments/{payment}', [LandlordPaymentController::class, 'update']) ->name('payments.update');
        Route::delete('payments/{payment}', [LandlordPaymentController::class, 'destroy']) ->name('payments.destroy');

        // Gestione spese

        Route::resource('expenses', \App\Http\Controllers\Web\Landlord\LandlordExpenseController::class);
        Route::get('yearly-reports', [\App\Http\Controllers\Web\Landlord\YearlyReportController::class, 'index']) ->name('yearly-reports.index');
        Route::get('yearly-reports/{report}/download', [\App\Http\Controllers\Web\Landlord\YearlyReportController::class, 'download']) ->name('yearly-reports.download');


        // Creazione inquilino + assegnazione contratto
        Route::get('tenants/create', [TenantManagementController::class, 'create'])->name('tenants.create');
        Route::post('tenants', [TenantManagementController::class, 'store'])->name('tenants.store');

        // Dashboard manutenzioni
        Route::get('maintenance', [MaintenanceDashboardController::class, 'index'])->name('maintenance.dashboard');

        // Gestione inquilini
        Route::get('/tenants', [LandlordTenantController::class, 'index']) ->name('tenants.index');
        Route::get('/tenants/{tenant}/assign', [LandlordTenantController::class, 'assignForm']) ->name('tenants.assignForm');
        Route::post('/tenants/{tenant}/assign', [LandlordTenantController::class, 'assignStore']) ->name('tenants.assignStore');
        Route::get('/landlord/leases/{lease}/pdf', [\App\Http\Controllers\Web\Landlord\LandlordLeasePdfController::class, 'show'])->name('leases.pdf');

        // Route::get('/tenants', [LandlordTenantController::class, 'index'])->name('.tenants.index');
        Route::get('/tenants/create', [LandlordTenantController::class, 'create'])->name('tenants.create');
        Route::post('/tenants', [LandlordTenantController::class, 'store'])->name('tenants.store');
        Route::delete('/leases/{lease}/tenant/{tenant}', [LandlordTenantController::class, 'detachFromLease'] )->name('tenants.detach');

});
    // -----------------------------------------------------
    //  FUNZIONALITÀ COMUNI
    // -----------------------------------------------------

    // Messaggi globali tenant ↔ landlord
    Route::resource('messages', MessagesController::class)->only(['index', 'create', 'store', 'show']);

    // PDF contratto
    Route::get('leases/{lease}/pdf', [LeasePdfController::class, 'downloadPdf'])->name('leases.pdf');

    // Profilo
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Stampa contratto 3+2
    Route::get('/leases/{lease}/contract-3-2', [ContractController::class, 'contract3plus2']) ->name('leases.contract.3plus2');
 }
)
// ---------------------------------------------------------
//  FINE AREA AUTENTICATA
;



