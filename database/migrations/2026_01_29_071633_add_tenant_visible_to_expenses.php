<?php
// database/migrations/2025_01_01_000002_add_tenant_visible_to_expenses.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->boolean('tenant_visible')
                  ->default(false)
                  ->after('amount');
        });
    }

    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('tenant_visible');
        });
    }
};
