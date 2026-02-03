<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');

Auth::routes(['register' => true, 'verify' => false]);

// Include sezioni
require __DIR__.'/admin.php';
require __DIR__.'/landlord.php';
require __DIR__.'/tenant.php';
