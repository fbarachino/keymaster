<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lease_id');
            $table->unsignedBigInteger('tenant_id');

            $table->date('due_date');
            $table->date('paid_date')->nullable();

            $table->decimal('amount_total', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0);

            $table->enum('status', ['pending', 'paid'])->default('pending');

            $table->string('description')->nullable();

            $table->timestamps();

            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
