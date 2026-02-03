<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdmin;

Route::middleware(['auth', EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('landlords', \App\Http\Controllers\Admin\LandlordController::class);

        Route::get('profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editPassword'])
            ->name('password.edit');

        Route::post('profile/password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])
            ->name('password.update');
    });
