@extends('layouts.public')

@section('title', 'Gracias — ' . $guest->event->name)

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-sm text-center space-y-6">

        @if($guest->rsvp_status === 'confirmed')

            {{-- ── Confirmado ──────────────────────────────────── --}}
            <div class="fade-up delay-1">
                <div class="text-6xl mb-3">🎉</div>
                <h1 class="text-2xl font-bold text-gray-900">¡Hasta pronto, {{ $guest->name }}!</h1>
                <p class="text-gray-500 mt-2 text-sm">
                    Tu asistencia está confirmada.
                    @if($guest->plus_ones > 0)
                        Estarán
                        <strong class="text-gray-700">{{ 1 + $guest->plus_ones }}</strong>
                        personas en total.
                    @endif
                </p>
            </div>

            {{-- Resumen del evento --}}
            <div class="fade-up delay-2 bg-gray-50 rounded-xl p-4 text-sm text-gray-600 text-left">
                <p class="font-semibold text-gray-800">{{ $guest->event->name }}</p>
                <p class="mt-1">📅 {{ $guest->event->event_date->translatedFormat('d \d\e F \d\e Y') }}</p>
                @if($guest->event->event_time)
                    <p class="mt-0.5">🕐 {{ \Carbon\Carbon::parse($guest->event->event_time)->format('g:i A') }}</p>
                @endif
                @if($guest->event->venue_name)
                    <p class="mt-0.5">📍 {{ $guest->event->venue_name }}</p>
                @endif
            </div>

            {{-- ── QR ticket de acceso ──────────────────────────── --}}
            <div class="fade-up delay-3 flex flex-col items-center gap-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest">Tu código de acceso</p>

                <div class="qr-ticket">
                    <canvas data-qr="{{ route('rsvp.show', $guest->token) }}"></canvas>
                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-800">{{ $guest->name }}</p>
                        @if($guest->plus_ones > 0)
                            <p class="text-xs text-gray-400 mt-0.5">
                                +{{ $guest->plus_ones }} acompañante{{ $guest->plus_ones > 1 ? 's' : '' }}
                            </p>
                        @endif
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-1">
                    Presenta este código en la entrada del evento
                </p>
            </div>

        @else

            {{-- ── Declinado ────────────────────────────────────── --}}
            <div class="fade-up delay-1">
                <div class="text-6xl mb-3">💌</div>
                <h1 class="text-2xl font-bold text-gray-900">Gracias por avisarnos</h1>
                <p class="text-gray-500 mt-2 text-sm">
                    Lamentamos que no puedas acompañarnos, {{ $guest->name }}.
                </p>
            </div>

            <div class="fade-up delay-2 bg-gray-50 rounded-xl p-4 text-sm text-gray-600">
                <p class="font-medium">{{ $guest->event->name }}</p>
                <p class="mt-1">{{ $guest->event->event_date->translatedFormat('d \d\e F \d\e Y') }}</p>
                @if($guest->event->venue_name)
                    <p class="mt-1">{{ $guest->event->venue_name }}</p>
                @endif
            </div>

        @endif

        <div class="fade-up delay-4">
            <a href="{{ route('rsvp.show', $guest->token) }}"
               class="text-sm text-indigo-500 hover:underline">
                Cambiar respuesta
            </a>
        </div>

    </div>
</div>
@endsection
