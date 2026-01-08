<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('leases', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('tenant_id');
        $table->unsignedBigInteger('unit_id');

        $table->date('start_date');
        $table->date('end_date')->nullable();

        $table->decimal('rent_amount', 10, 2);
        $table->decimal('deposit_amount', 10, 2)->nullable();

        $table->text('notes')->nullable();
        $table->timestamp('signed_by_tenant_at')->nullable();
        $table->timestamp('signed_by_landlord_at')->nullable();
        $table->string('signature_token')->nullable()->unique();

        $table->timestamps();

        $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
