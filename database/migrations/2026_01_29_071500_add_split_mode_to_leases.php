<?php

// database/migrations/2025_01_01_000001_add_split_mode_to_leases.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->enum('split_mode', ['equal', 'full'])
                  ->default('equal')
                  ->after('rent_amount');
        });
    }

    public function down()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->dropColumn('split_mode');
        });
    }
};
