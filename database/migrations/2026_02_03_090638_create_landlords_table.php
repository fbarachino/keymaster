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
        Schema::create('landlords', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            // Anagrafica
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('fiscal_code')->nullable();
            $table->string('nationality')->nullable();

            // Residenza
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();

            // Documento
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->date('document_issue_date')->nullable();
            $table->date('document_expiry_date')->nullable();
            $table->string('document_issuer')->nullable();

            // Contatti
            $table->string('phone')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landlords');
    }
};
