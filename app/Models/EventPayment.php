<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPayment extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'stripe_session_id',
        'stripe_payment_intent',
        'status',
        'amount_mxn',
        'guest_count',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function amountFormatted(): string
    {
        return '$' . number_format($this->amount_mxn / 100, 2) . ' MXN';
    }
}
