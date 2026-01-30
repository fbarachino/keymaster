<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            // Nuovo riferimento al tenant
            if (!Schema::hasColumn('payments', 'tenant_id')) {
                $table->foreignId('tenant_id')
                    ->nullable()
                    ->after('lease_id')
                    ->constrained()
                    ->cascadeOnDelete();
            }

            // Importo dovuto dal singolo tenant
            if (!Schema::hasColumn('payments', 'amount_due')) {
                $table->decimal('amount_due', 10, 2)
                    ->default(0)
                    ->after('amount');
            }

            // Importo effettivamente pagato
            if (!Schema::hasColumn('payments', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)
                    ->default(0)
                    ->after('amount_due');
            }

            // Data effettiva del pagamento
            if (!Schema::hasColumn('payments', 'paid_at')) {
                $table->dateTime('paid_at')
                    ->nullable()
                    ->after('due_date');
            }

            // Stato del pagamento
            if (!Schema::hasColumn('payments', 'status')) {
                $table->enum('status', ['pending', 'paid', 'partial', 'overdue'])
                    ->default('pending')
                    ->after('paid_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'tenant_id',
                'amount_due',
                'amount_paid',
                'paid_at',
                'status',
            ]);
        });
    }
};

