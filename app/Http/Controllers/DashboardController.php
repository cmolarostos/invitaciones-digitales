<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ─── Eventos del usuario ──────────────────────────────────
        $events = $user->events()
            ->with(['guests', 'template'])
            ->withTrashed()
            ->latest()
            ->get();

        $activeEvents = $events->whereNull('deleted_at');

        // ─── Totales globales ─────────────────────────────────────
        $totalGuests    = $activeEvents->sum(fn ($e) => $e->guests->count());
        $totalConfirmed = $activeEvents->sum(fn ($e) => $e->guests->where('rsvp_status', 'confirmed')->count());
        $totalDeclined  = $activeEvents->sum(fn ($e) => $e->guests->where('rsvp_status', 'declined')->count());
        $totalPending   = $activeEvents->sum(fn ($e) => $e->guests->where('rsvp_status', 'pending')->count());

        // Total asistentes reales (invitado + acompañantes)
        $totalAttendees = $activeEvents->sum(function ($e) {
            return $e->guests->where('rsvp_status', 'confirmed')
                ->sum(fn ($g) => 1 + $g->plus_ones);
        });

        // ─── Actividad reciente (últimas 15 respuestas) ───────────
        $recentActivity = $user->events()
            ->with('guests')
            ->get()
            ->pluck('guests')
            ->flatten()
            ->whereIn('rsvp_status', ['confirmed', 'declined'])
            ->whereNotNull('rsvp_at')
            ->sortByDesc('rsvp_at')
            ->take(15);

        // ─── Stats por evento ─────────────────────────────────────
        $eventStats = $activeEvents->map(function ($event) {
            $guests    = $event->guests;
            $total     = $guests->count();
            $confirmed = $guests->where('rsvp_status', 'confirmed')->count();
            $declined  = $guests->where('rsvp_status', 'declined')->count();
            $pending   = $guests->where('rsvp_status', 'pending')->count();
            $attendees = $guests->where('rsvp_status', 'confirmed')
                ->sum(fn ($g) => 1 + $g->plus_ones);

            return [
                'event'          => $event,
                'total'          => $total,
                'confirmed'      => $confirmed,
                'declined'       => $declined,
                'pending'        => $pending,
                'attendees'      => $attendees,
                'confirmed_pct'  => $total > 0 ? round($confirmed / $total * 100) : 0,
                'declined_pct'   => $total > 0 ? round($declined  / $total * 100) : 0,
                'pending_pct'    => $total > 0 ? round($pending   / $total * 100) : 0,
            ];
        });

        return view('dashboard.index', compact(
            'activeEvents',
            'totalGuests',
            'totalConfirmed',
            'totalDeclined',
            'totalPending',
            'totalAttendees',
            'recentActivity',
            'eventStats',
        ));
    }
}
