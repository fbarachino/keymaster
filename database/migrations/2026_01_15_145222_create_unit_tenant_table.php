<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('unit_tenant', function (Blueprint $table) {
        $table->id();

        $table->foreignId('unit_id')->constrained()->onDelete('cascade');
        $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');

        // Ruolo nel contratto
        $table->boolean('is_primary')->default(false);

        // Tipo di ripartizione spese
        $table->string('share_type')->default('none');
        // equal, custom, none

        // Percentuale o quota personalizzata
        $table->decimal('share_value', 5, 2)->nullable(); // es: 0.50

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_tenant');
    }
};
