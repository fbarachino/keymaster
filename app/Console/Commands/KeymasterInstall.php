<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Lease;

class KeymasterInstall extends Command
{
    protected $signature = 'keymaster:install';
    protected $description = 'Installa KeyMaster: migra DB, crea admin, dati demo, ruoli e permessi';

    public function handle()
    {
        $this->info('🚀 Avvio installazione KeyMaster...');

        // 1) MIGRAZIONI
        $this->info('📦 Eseguo le migrazioni...');
        Artisan::call('migrate', ['--force' => true]);
        $this->info(Artisan::output());

        // 2) CREA ADMIN
        $this->info('👑 Creo utente ADMIN...');

        $admin = User::firstOrCreate(
            ['email' => 'admin@keymaster.local'],
            [
                'first_name' => 'System',
                'last_name'  => 'Administrator',
                'name'       => 'System Administrator',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
            ]
        );

        $this->info("   → Admin creato o già esistente: {$admin->email}");

        // 3) CREA DATI DEMO
        $this->info('🏡 Creo dati demo...');

        // Landlord demo
        $landlord = User::firstOrCreate(
            ['email' => 'landlord@demo.local'],
            [
                'first_name' => 'Mario',
                'last_name'  => 'Rossi',
                'name'       => 'Mario Rossi',
                'password'   => Hash::make('password'),
                'role'       => 'landlord',
            ]
        );

        // Property demo
        $property = Property::firstOrCreate(
            ['name' => 'Condominio Demo'],
            [
                'landlord_id' => $landlord->id,
                'address'     => 'Via Roma 1',
                'city'        => 'Trento',
            ]
        );

        // Unit demo
        $unit = Unit::firstOrCreate(
            ['name' => 'Appartamento 1'],
            [
                'property_id' => $property->id,
                'floor'       => 1,
                'internal_code' => 'A1',
            ]
        );

        // Tenant demo
        $tenant = User::firstOrCreate(
            ['email' => 'tenant@demo.local'],
            [
                'first_name' => 'Paolo',
                'last_name'  => 'Bianchi',
                'name'       => 'Paolo Bianchi',
                'password'   => Hash::make('password'),
                'role'       => 'tenant',
            ]
        );

        // Lease demo
        $lease = Lease::firstOrCreate(
            [
                'unit_id' => $unit->id,
                'start_date' => '2024-01-01',
            ],
            [
                'end_date' => '2028-12-31',
                'rent_amount' => 800,
                'advance_expenses' => 100,
                'deposit_amount' => 1500,
            ]
        );

        // Associa tenant alla lease
        $lease->tenants()->syncWithoutDetaching([$tenant->id]);

        $this->info('   → Dati demo creati.');

        // 4) CONFIGURA RUOLI E PERMESSI (se usi spatie/permission)
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $this->info('🔐 Configuro ruoli e permessi...');

            $this->setupRolesAndPermissions();

            $this->info('   → Ruoli e permessi configurati.');
        } else {
            $this->info('⚠️ Spatie/Permission non installato: salto configurazione ruoli.');
        }

        $this->info('🎉 Installazione completata con successo!');
        return Command::SUCCESS;
    }

    protected function setupRolesAndPermissions()
    {
        $roleClass = \Spatie\Permission\Models\Role::class;
        $permissionClass = \Spatie\Permission\Models\Permission::class;

        $adminRole = $roleClass::firstOrCreate(['name' => 'admin']);
        $landlordRole = $roleClass::firstOrCreate(['name' => 'landlord']);
        $tenantRole = $roleClass::firstOrCreate(['name' => 'tenant']);

        $permissions = [
            'manage landlords',
            'manage properties',
            'manage units',
            'manage leases',
            'manage tenants',
        ];

        foreach ($permissions as $perm) {
            $permissionClass::firstOrCreate(['name' => $perm]);
        }

        $adminRole->syncPermissions($permissions);
        $landlordRole->syncPermissions(['manage properties', 'manage units', 'manage leases', 'manage tenants']);
        $tenantRole->syncPermissions([]);
    }
}
