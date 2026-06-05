<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('gifts_title', 200)->nullable()->after('youtube_url');
            $table->string('gifts_subtitle', 400)->nullable()->after('gifts_title');
            $table->json('gifts')->nullable()->after('gifts_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['gifts_title', 'gifts_subtitle', 'gifts']);
        });
    }
};
