<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_session_id')->unique()->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->unsignedInteger('amount_mxn');      // en centavos: 29900 = $299 MXN
            $table->unsignedInteger('guest_count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_payments');
    }
};
