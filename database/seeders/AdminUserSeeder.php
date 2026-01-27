<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Evita duplicati se la seed viene eseguita più volte
        if (!User::where('email', 'admin@keymaster.local')->exists()) {

            User::create([
                'first_name' => 'System',
                'last_name'  => 'Administrator',
                'name'       => 'System Administrator',
                'email'      => 'admin@keymaster.local',
                'password'   => Hash::make(env('ADMIN_PASSWORD', 'admin123')), // puoi cambiarla
                'role'       => 'admin',
            ]);
        }
    }
}
