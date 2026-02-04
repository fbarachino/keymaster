<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lease_id');
            $table->unsignedBigInteger('tenant_id')->nullable(); // se spesa condivisa
            $table->unsignedBigInteger('property_id');

            $table->string('category'); // es: acqua, luce, gas, condominio
            $table->string('description')->nullable();

            $table->decimal('amount_total', 10, 2);
            $table->decimal('amount_tenant', 10, 2)->nullable(); // quota personale

            $table->date('expense_date');

            $table->timestamps();

            $table->foreign('lease_id')->references('id')->on('leases')->onDelete('cascade');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
