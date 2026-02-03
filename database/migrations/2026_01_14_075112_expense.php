<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('expenses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('property_id')->constrained()->cascadeOnDelete();
        $table->foreignId('unit_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('lease_id')->nullable()->constrained()->nullOnDelete();
        $table->string('description');
        $table->decimal('amount_total', 10, 2);
        $table->boolean('tenant_visible')->default(false);
        $table->enum('charged_to', ['landlord', 'tenant', 'both'])->default('tenants');
        $table->decimal('tenant_share', 10, 2)->nullable();
        $table->decimal('landlord_share', 10, 2)->nullable();
        $table->date('date');
        $table->text('notes')->nullable();
        $table->timestamps();


    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('expenses');
    }
};
