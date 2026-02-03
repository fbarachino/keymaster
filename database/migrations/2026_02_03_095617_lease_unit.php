<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lease_unit', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lease_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('unit_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // opzionale: peso della unit per split_mode = unit_based
            $table->decimal('weight', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lease_unit');
    }
};
