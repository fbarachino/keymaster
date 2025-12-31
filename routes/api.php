<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Portal\Tenant\{
    TenantDashboardController,
    TenantLeaseController,
    TenantPaymentController,
    TenantMessageController
};

use App\Http\Controllers\Portal\Landlord\{
    LandlordDashboardController,
    LandlordPropertyController,
    LandlordUnitController,
    LandlordLeaseController,
    LandlordMessageController
};

Route::middleware('auth:sanctum')->group(function () {

    // TENANT PORTAL
    Route::prefix('tenant')->group(function () {
        Route::get('dashboard', [TenantDashboardController::class, 'index']);
        Route::get('leases', [TenantLeaseController::class, 'index']);
        Route::get('leases/{lease}', [TenantLeaseController::class, 'show']);
        Route::get('payments', [TenantPaymentController::class, 'index']);
        Route::get('payments/{payment}', [TenantPaymentController::class, 'show']);
        Route::get('messages', [TenantMessageController::class, 'index']);
        Route::post('messages', [TenantMessageController::class, 'store']);
    });

    // LANDLORD PORTAL
    Route::prefix('landlord')->group(function () {
        Route::get('dashboard', [LandlordDashboardController::class, 'index']);
        Route::get('properties', [LandlordPropertyController::class, 'index']);
        Route::get('properties/{property}', [LandlordPropertyController::class, 'show']);
        Route::get('units/{unit}', [LandlordUnitController::class, 'show']);
        Route::get('leases', [LandlordLeaseController::class, 'index']);
        Route::get('leases/{lease}', [LandlordLeaseController::class, 'show']);
        Route::get('messages', [LandlordMessageController::class, 'index']);
        Route::post('messages', [LandlordMessageController::class, 'store']);
    });

});
