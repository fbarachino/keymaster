<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {

            // Se l'utente non è autenticato, esci subito
            if (!auth()->check()) {
                return;
            }

            $user = auth()->user();

            // Menu Landlord
            $itemsLandlord = [
                ['text' => 'Dashboard', 'route' => 'landlord.dashboard','icon' => 'far fa-fw fa-dashboard'],
                ['text' => 'Proprietà', 'route' => 'landlord.properties.index','icon' => 'far fa-fw fa-building'],
                ['text' => 'Contratti', 'route' => 'landlord.leases.index' ,'icon' => 'far fa-fw fa-file-contract'],
                ['text' => 'Inquilini & Contratti', 'route' => 'landlord.tenants.index','icon' => 'far fa-fw fa-users'],
                ['text' => 'Pagamenti', 'route' => 'landlord.payments.index','icon' => 'far fa-fw fa-credit-card'],
                ['text' => 'Ticket di manutenzione', 'route' => 'landlord.tickets.index','icon' => 'far fa-fw fa-tools'],
                ['text' => 'Dashboard manutenzioni', 'route' => 'landlord.maintenance.dashboard','icon' => 'far fa-fw fa-tachometer-alt'],
                ['text' => 'Messaggi', 'route' => 'landlord.messages.index','icon' => 'far fa-fw fa-envelope'],
                ['text' => 'Nuovo messaggio', 'route' => 'landlord.messages.create','icon' => 'far fa-fw fa-edit'],
            ];

            if ($user->role === 'landlord') {
                foreach ($itemsLandlord as $item) {
                    $event->menu->add($item);
                }
            }

            // Menu Tenant
            $itemsTenant = [
                ['text' => 'Dashboard', 'route' => 'tenant.dashboard','icon' => 'far fa-fw fa-dashboard'],
                ['text' => 'I miei contratti', 'route' => 'tenant.leases.index','icon' => 'far fa-fw fa-file-contract'],
                ['text' => 'I miei pagamenti', 'route' => 'tenant.payments.index','icon' => 'far fa-fw fa-credit-card'],
                ['text' => 'I miei ticket di manutenzione', 'route' => 'tenant.tickets.index','icon' => 'far fa-fw fa-tools'],
                ['text' => 'Messaggi', 'route' => 'tenant.messages.index','icon' => 'far fa-fw fa-envelope'],
                ['text' => 'Nuovo messaggio', 'route' => 'tenant.messages.create','icon' => 'far fa-fw fa-edit'],
            ];

            if ($user->role === 'tenant') {
                foreach ($itemsTenant as $item) {
                    $event->menu->add($item);
                }
            }
        });
    }
}
