<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']); // rimuove FK
        });

        Schema::table('leases', function (Blueprint $table) {
            $table->dropColumn('tenant_id'); // rimuove colonna
        });
    }

    public function down()
    {
        Schema::table('leases', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->constrained('users');
        });
    }
};
