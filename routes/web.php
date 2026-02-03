<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');

Auth::routes(['register' => true, 'verify' => false]);

Route::middleware('auth')->group(function () {
    Route::get('notifications', [\App\Http\Controllers\Web\NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('notifications/{notification}/read', [\App\Http\Controllers\Web\NotificationController::class, 'markRead'])
        ->name('notifications.read');
});


// Include sezioni
require __DIR__.'/admin.php';
require __DIR__.'/landlord.php';
require __DIR__.'/tenant.php';
