<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // Relazioni
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('landlord_id');

            // Thread (risposte)
            $table->unsignedBigInteger('parent_id')->nullable();

            // Contenuto
            $table->string('subject')->nullable();
            $table->text('message');

            // Chi ha inviato il messaggio
            $table->enum('sender', ['tenant', 'landlord']);

            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('landlord_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
