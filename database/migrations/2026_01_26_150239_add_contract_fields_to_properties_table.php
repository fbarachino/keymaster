<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {

            // Indirizzo completo
            // $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();

            // Dati catastali
            $table->string('cadastral_sheet')->nullable();      // foglio
            $table->string('cadastral_particle')->nullable();   // particella
            $table->string('cadastral_sub')->nullable();        // subalterno
            $table->string('cadastral_category')->nullable();   // es. A/2
            $table->string('cadastral_class')->nullable();
            $table->decimal('cadastral_rent', 10, 2)->nullable(); // rendita catastale
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'address', 'zip', 'city', 'province', 'country',
                'cadastral_sheet', 'cadastral_particle', 'cadastral_sub',
                'cadastral_category', 'cadastral_class', 'cadastral_rent'
            ]);
        });
    }
};
