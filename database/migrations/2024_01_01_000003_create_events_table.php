<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();           // boda-ana-y-carlos
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->string('venue_maps_url')->nullable();
            $table->string('dress_code')->nullable();
            $table->text('notes')->nullable();
            $table->json('custom_colors')->nullable();  // sobreescribe los de la plantilla
            $table->enum('status', ['draft', 'published', 'sent', 'completed'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
