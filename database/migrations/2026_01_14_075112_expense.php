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
        $table->unsignedBigInteger('lease_id');
        $table->string('type'); // es: "Condominio", "IMU", "Manutenzione"
        $table->decimal('amount', 10, 2);
        $table->enum('charged_to', ['landlord', 'tenant', 'both']);
        $table->decimal('tenant_share', 10, 2)->nullable();
        $table->decimal('landlord_share', 10, 2)->nullable();
        $table->date('date');
        $table->text('notes')->nullable();
        $table->timestamps();

        $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');
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
