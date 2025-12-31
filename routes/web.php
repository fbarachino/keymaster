<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MessagesController;
use App\Http\Controllers\Web\Landlord\UnitCrudController;
use App\Http\Controllers\Web\Tenant\TenantLeaseController;
use App\Http\Controllers\Web\Landlord\PaymentCrudController;
use App\Http\Controllers\Web\Tenant\TenantDocumentsController;
use App\Http\Controllers\Web\Landlord\TenantManagementController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tenant/dashboard', [App\Http\Controllers\Web\Tenant\TenantDashboardController::class, 'index'])->name('tenant.dashboard');
Route::get('/landlord/dashboard', [App\Http\Controllers\Web\Landlord\LandlordDashboardController::class, 'index'])->name('landlord.dashboard');
// LANDLORD CRUD
Route::middleware(['auth'])->prefix('landlord')->group(function () {

    // Proprietà
    Route::resource('properties', App\Http\Controllers\Web\Landlord\PropertyCrudController::class);

    // Unità
    Route::get('properties/{property}/units', [App\Http\Controllers\Web\Landlord\UnitCrudController::class, 'index'])->name('landlord.units.index');
    Route::get('properties/{property}/units/create', [App\Http\Controllers\Web\Landlord\UnitCrudController::class, 'create'])->name('landlord.units.create');
    Route::post('properties/{property}/units', [App\Http\Controllers\Web\Landlord\UnitCrudController::class, 'store'])->name('landlord.units.store');

    // Contratti
    Route::resource('leases', App\Http\Controllers\Web\Landlord\LeaseCrudController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {

    // PAGAMENTI (solo landlord)
    Route::middleware('landlord')->prefix('landlord')->group(function () {
        Route::resource('payments', PaymentCrudController::class);
    });

    // MESSAGGI (tenant ↔ landlord)
    Route::resource('messages', MessagesController::class)->only(['index','create','store','show']);
});


Route::middleware(['auth'])->prefix('landlord')->group(function () {
    Route::get('tenants/create', [TenantManagementController::class, 'create'])
        ->name('landlord.tenants.create');

    Route::post('tenants', [TenantManagementController::class, 'store'])
        ->name('landlord.tenants.store');
});



Route::middleware(['auth'])->prefix('landlord')->group(function () {

    // CRUD unità
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
});
Route::post('properties/{property}/units/{unit}/photos',
    [UnitCrudController::class, 'uploadPhotos']
)->name('landlord.units.photos.upload');
Route::post('properties/{property}/units/{unit}/inventory',
    [UnitCrudController::class, 'addInventory']
)->name('landlord.units.inventory.add');
Route::post('properties/{property}/units/{unit}/documents',
    [UnitCrudController::class, 'uploadDocument']
)->name('landlord.units.documents.upload');
Route::get('leases/{lease}/pdf', [TenantLeaseController::class, 'downloadPdf']) ->name('leases.pdf');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'tenant'])->group(function () {
    Route::get('tenant/documents', [TenantDocumentsController::class, 'index'])
        ->name('tenant.documents.index');
});
