<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
        URL::forceScheme('https');
        }

        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // Se l'utente non è autenticato, esci subito
            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();

            // Menu Landlord
            $itemsLandlord = [
                ['text' => 'Dashboard', 'route' => 'landlord.dashboard','icon' => 'fas fa-tachometer-alt'],
                ['text' => 'Proprietà', 'route' => 'landlord.properties.index','icon' => 'fas fa-building'],
                ['text' => 'Contratti', 'route' => 'landlord.leases.index' ,'icon' => 'fas fa-file-contract'],
            //    ['text' => 'Inquilini & Contratti', 'route' => 'landlord.tenants.index','icon' => 'far fa-fw fa-users'],
                ['text' => 'Pagamenti', 'route' => 'landlord.payments.index','icon' => 'far fa-fw fa-credit-card'],
                ['text' => 'Ticket di manutenzione', 'route' => 'landlord.tickets.index','icon' => 'fas fa-exclamation-triangle'],
                ['text' => 'Dashboard manutenzioni', 'route' => 'landlord.maintenance.dashboard','icon' => 'fas fa-tachometer-alt'],
                ['text' => 'Messaggi', 'route' => 'landlord.messages.index','icon' => 'far fa-fw fa-envelope'],
            //    ['text' => 'Nuovo messaggio', 'route' => 'landlord.messages.create','icon' => 'far fa-fw fa-edit'],
                [ 'text' => 'Spese', 'url' => 'landlord/expenses', 'icon' => 'fas fa-receipt'], // se usi Gate o middleware ]
                [ 'text' => 'Conguagli annuali', 'url' => 'landlord/yearly-reports', 'icon' => 'fas fa-file-invoice-dollar', ],
                [ 'text' => 'Profilo', 'url' => 'profile', 'icon' => 'fas fa-user-cog', 'topnav_user' => true,], // <— questa è la chiave importante
            ];

            if ($user->role === 'landlord') {
                foreach ($itemsLandlord as $item) {
                    $event->menu->add($item);
                }
            }

            // Menu Tenant
            $itemsTenant = [
                ['text' => 'Dashboard', 'route' => 'tenant.dashboard','icon' => 'fas fa-tachometer-alt'],
                ['text' => 'Le mie proprietà', 'route' => 'tenant.properties.index','icon' => 'fas fa-building'],
                ['text' => 'I miei contratti', 'route' => 'tenant.leases.index','icon' => 'fas fa-file-contract'],
                ['text' => 'I miei pagamenti', 'route' => 'tenant.payments.index','icon' => 'far fa-fw fa-credit-card'],
                ['text' => 'Ticket di manutenzione', 'route' => 'tenant.tickets.index','icon' => 'fas fa-exclamation-triangle'],
                ['text' => 'Messaggi', 'route' => 'tenant.messages.index','icon' => 'far fa-fw fa-envelope'],
            //    ['text' => 'Nuovo messaggio', 'route' => 'tenant.messages.create','icon' => 'far fa-fw fa-edit'],
                [ 'text' => 'Conguagli annuali', 'url' => 'tenant/yearly-reports', 'icon' => 'fas fa-file-invoice-dollar', ],
                [ 'text' => 'Profilo', 'url' => 'profile', 'icon' => 'fas fa-user-cog', 'topnav_user' => true, ],
            ]; // <— questa è la chiave importante

            if ($user->role === 'tenant') {
                foreach ($itemsTenant as $item) {
                    $event->menu->add($item);
                }
            }

            $itemsAdmin = [
                [ 'text' => 'Cambia Password', 'route' => 'admin.password.edit', 'icon' => 'nav-icon fas fa-key', 'topnav_user' => true, ],
            ];

            if ($user->role === 'admin') {
                foreach ($itemsAdmin as $item) {
                    $event->menu->add($item);
                }
            }
        });
    }
}
