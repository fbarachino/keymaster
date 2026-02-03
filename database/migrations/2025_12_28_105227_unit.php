<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');                 // es: Appartamento 1
            $table->string('type')->nullable();     // es: appartamento, garage, ufficio
            $table->integer('floor')->nullable();   // piano
            $table->decimal('size_sqm', 8, 2)->nullable(); // mq

            // Campi aggiuntivi
            $table->string('interior')->nullable();     // interno
            $table->integer('rooms')->nullable();       // numero vani
            $table->string('accessory')->nullable();    // cantina, garage, ecc.
            $table->string('status')->default('available'); // available | occupied

            $table->decimal('monthly_rent', 10, 2)->nullable(); // canone unitario

            $table->text('notes')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
