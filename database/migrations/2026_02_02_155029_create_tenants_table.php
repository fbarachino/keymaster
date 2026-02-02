<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            // Anagrafica
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('fiscal_code')->nullable();

            // Documento
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('document_issued_by')->nullable();
            $table->date('document_issued_at')->nullable();
            $table->date('document_expiry_date')->nullable();

            // Contatti
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();

            // Dati contrattuali
            $table->string('occupation')->nullable();
            $table->text('notes')->nullable();

            // Collegamento opzionale all'utente
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
