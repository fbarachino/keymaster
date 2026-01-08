<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Relazioni principali
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('landlord_id');
            $table->unsignedBigInteger('unit_id');

            // Contenuto del ticket
            $table->string('title');
            $table->text('description');

            // Stato del ticket
            $table->enum('status', ['open', 'in_progress', 'closed'])
                  ->default('open');

            // Priorità
            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('medium');

            // Allegati (foto, documenti)
            $table->json('attachments')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('tenant_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('landlord_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('unit_id')
                  ->references('id')->on('units')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
