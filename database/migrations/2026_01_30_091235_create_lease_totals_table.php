<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lease_totals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lease_id')
                ->constrained()
                ->cascadeOnDelete();

            // Periodo di riferimento, es: "2025-01" oppure "2025"
            $table->string('period'); // es: "2025-01" per mensile, "2025" per annuale

            // Totali economici riferiti alla lease per quel periodo
            $table->decimal('rent_total', 10, 2)->default(0);          // canone totale
            $table->decimal('expenses_total', 10, 2)->default(0);      // spese effettive
            $table->decimal('advance_total', 10, 2)->default(0);       // anticipi richiesti
            $table->decimal('settlement_total', 10, 2)->default(0);    // conguaglio (+ a debito, - a credito)

            // Eventuale tipo di periodo: monthly / yearly (se vuoi distinguere)
            $table->enum('period_type', ['monthly', 'yearly'])->default('monthly');

            $table->timestamps();

            $table->unique(['lease_id', 'period', 'period_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lease_totals');
    }
};
