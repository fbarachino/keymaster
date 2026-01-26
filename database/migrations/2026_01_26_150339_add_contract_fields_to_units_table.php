<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {

           // $table->string('floor')->nullable();        // piano
            $table->string('interior')->nullable();     // interno
            $table->integer('rooms')->nullable();       // numero vani
            //$table->integer('surface')->nullable();     // mq
            $table->string('accessory')->nullable();    // cantina, garage, ecc.
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn([
               'interior', 'rooms', 'accessory'
            ]);
        });
    }
};
