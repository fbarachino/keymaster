<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lease_tenant', function (Blueprint $table) {
            $table->id();

            $table->foreignId('lease_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

            // Per split_mode = percentage
            $table->decimal('percentage', 5, 2)->nullable();

            // Per split_mode = fixed
            $table->decimal('fixed_amount', 10, 2)->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('lease_tenant');
    }
};
