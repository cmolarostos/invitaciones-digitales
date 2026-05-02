<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone', 20);               // formato E.164: +521234567890
            $table->string('token', 64)->unique();      // UUID para el link de RSVP
            $table->enum('rsvp_status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->timestamp('rsvp_at')->nullable();
            $table->tinyInteger('plus_ones')->default(0);
            $table->text('rsvp_notes')->nullable();     // mensaje del invitado al confirmar
            $table->timestamps();

            $table->unique(['event_id', 'phone']);      // un invitado por teléfono por evento
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
