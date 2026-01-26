<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Anagrafica
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
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
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'birth_date', 'birth_place',
                'fiscal_code', 'nationality', 'address', 'zip', 'city',
                'province', 'country', 'document_type', 'document_number',
                'document_issue_date', 'document_expiry_date', 'document_issuer',
                'phone'
            ]);
        });
    }
};
