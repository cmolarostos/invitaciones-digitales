<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('notes');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('godfather_name')->nullable()->after('mother_name');
            $table->string('godmother_name')->nullable()->after('godfather_name');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['father_name', 'mother_name', 'godfather_name', 'godmother_name']);
        });
    }
};
