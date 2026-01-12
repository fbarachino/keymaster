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
        Schema::create('threads', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('landlord_id');
        $table->unsignedBigInteger('tenant_id');
        $table->string('subject')->nullable();
        $table->timestamps();

        $table->foreign('landlord_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('tenant_id')->references('id')->on('users')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
