<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('landlord_id');
            $table->string('name');
            $table->string('address');
            $table->text('description')->nullable();
            $table->timestamps();

            // SQLite non supporta foreign key complesse, ma Laravel le gestisce comunque
            $table->foreign('landlord_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
