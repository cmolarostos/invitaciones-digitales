<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function show(string $token): View
    {
        $guest = Guest::with('event.template')->where('token', $token)->firstOrFail();

        return view('rsvp.show', compact('guest'));
    }

    public function confirm(Request $request, string $token): RedirectResponse
    {
        $guest = Guest::where('token', $token)->firstOrFail();

        $data = $request->validate([
            'rsvp_status' => ['required', 'in:confirmed,declined'],
            'plus_ones'   => ['required_if:rsvp_status,confirmed', 'integer', 'min:0', 'max:10'],
            'rsvp_notes'  => ['nullable', 'string', 'max:500'],
        ]);

        $guest->update([
            'rsvp_status' => $data['rsvp_status'],
            'plus_ones'   => $data['plus_ones'] ?? 0,
            'rsvp_notes'  => $data['rsvp_notes'] ?? null,
            'rsvp_at'     => now(),
        ]);

        return redirect()->route('rsvp.thankyou', $token);
    }

    public function thankyou(string $token): View
    {
        $guest = Guest::with('event')->where('token', $token)->firstOrFail();

        return view('rsvp.thankyou', compact('guest'));
    }
}
