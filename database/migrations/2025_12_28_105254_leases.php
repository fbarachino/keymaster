<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('leases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('property_id') ->constrained() ->cascadeOnDelete();

        // Date del contratto
        $table->date('start_date');
        $table->date('end_date')->nullable();

        // Importi
        $table->decimal('rent_amount', 10, 2);
        $table->decimal('advance_expenses', 10, 2)->default(0);

        // Deposito cauzionale
        $table->decimal('deposit_amount', 10, 2)->nullable();

        // Modalità di ripartizione
       $table->enum('split_mode', [ 'equal', // divisione equa
       'percentage', // percentuale per tenant
       'fixed', // importo fisso per tenant
       'unit_based', // basato sulle unit
       'custom', // logica personalizzata
       ])->default('equal');

        // Stato della lease
            $table->enum('status', [
                'active',
                'terminated',
                'pending',
            ])->default('active');
        $table->text('notes')->nullable();
        $table->timestamp('signed_by_tenant_at')->nullable();
        $table->timestamp('signed_by_landlord_at')->nullable();
        $table->string('signature_token')->nullable()->unique();
        $table->string('signature_path')->nullable();
        $table->timestamp('signed_at')->nullable();
        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
