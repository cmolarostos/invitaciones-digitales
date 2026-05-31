<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('dress_code_men', 300)->nullable()->after('dress_code');
            $table->string('dress_code_women', 300)->nullable()->after('dress_code_men');
            $table->json('dress_code_colors')->nullable()->after('dress_code_women');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['dress_code_men', 'dress_code_women', 'dress_code_colors']);
        });
    }
};
