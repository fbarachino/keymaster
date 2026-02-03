<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_landlord', function (Blueprint $table) {
            $table->id();

            $table->foreignId('property_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('landlord_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Percentuale di proprietà (es: 100, 50/50, ecc.)
            $table->decimal('ownership_percentage', 5, 2)->default(100);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_landlord');
    }
};
