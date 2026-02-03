<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Tenant che deve pagare
            $table->foreignId('tenant_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Lease a cui si riferisce il pagamento
            $table->foreignId('lease_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Importo dovuto e pagato
            $table->decimal('amount_due', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0);

            // Stato del pagamento
            $table->enum('status', [
                'pending',      // non pagato
                'partial',      // pagato in parte
                'paid',         // pagato completamente
                'overdue',      // scaduto
            ])->default('pending');

            // Date
            $table->date('due_date')->nullable();       // scadenza
            $table->date('paid_at')->nullable();        // data pagamento

            // Descrizione (es: "Canone + anticipo spese 02/2026")
            $table->string('description')->nullable();

            // Note interne
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
