<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('name');
            $table->integer('floor')->nullable();
            $table->integer('size')->nullable();
            $table->decimal('monthly_rent', 10, 2);
            $table->string('status')->default('available'); // available | occupied
            $table->timestamps();

            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
