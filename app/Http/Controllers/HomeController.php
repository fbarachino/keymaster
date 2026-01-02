<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Landlord\LandlordDashboardController;
use App\Http\Controllers\Web\Tenant\TenantDashboardController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'landlord'){
            //Route::get('/home', [LandlordDashboardController::class, 'index'])->name('home');
            return redirect()->route('landlord.dashboard');
        } elseif(Auth::user()->role == 'tenant'){
            //Route::get('/home', [TenantDashboardController::class,'index'])->name('home');
            return redirect()->route('tenant.dashboard');
        } else {
            Route::get('/home', function () { return view('welcome'); })->name('home');
        }
    }
}
