<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('whatsapp_message_id')->nullable()->unique(); // ID de Meta
            $table->enum('type', ['invitation', 'reminder', 'update'])->default('invitation');
            $table->enum('delivery_status', ['queued', 'sent', 'delivered', 'read', 'failed'])
                  ->default('queued');
            $table->text('error_message')->nullable();  // si falla, guardamos el motivo
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_logs');
    }
};
