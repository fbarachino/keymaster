<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Informazioni generali
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            // Prezzo di acquisto
            $table->decimal('purchase_price', 12, 2)->nullable();

            // Indirizzo
            $table->string('address')->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('city')->nullable();
            $table->string('province', 50)->nullable();
            $table->string('country')->nullable();

            // Dati catastali
            $table->string('cadastral_sheet')->nullable();
            $table->string('cadastral_particle')->nullable();
            $table->string('cadastral_sub')->nullable();
            $table->string('cadastral_category')->nullable();
            $table->string('cadastral_class')->nullable();
            $table->decimal('cadastral_rent', 10, 2)->nullable();

            // Note interne
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
