<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('language', 5)->default('it')->after('email');
            $table->string('notification_preference')->default('email')->after('language');
            $table->string('telegram_chat_id')->nullable()->after('notification_preference');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['language', 'notification_preference', 'telegram_chat_id']);
        });
    }
};
