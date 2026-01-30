<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lease_id');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['rent', 'deposit', 'expense', 'advance-expenses', 'expense-settlement', 'other'])->default('rent');
            $table->string('status')->default('pending'); // pending | paid | overdue
            $table->timestamps();
            $table->string('notes')->nullable();
            $table->string('reference')->nullable();
            $table->foreign('lease_id')->references('id')->on('leases');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
