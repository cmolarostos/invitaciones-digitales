@extends('layouts.public')

@section('title', 'Gracias — ' . $guest->event->name)

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm text-center">

        @if($guest->rsvp_status === 'confirmed')
            <div class="text-6xl mb-4">🎉</div>
            <h1 class="text-2xl font-bold text-gray-900">¡Hasta pronto, {{ $guest->name }}!</h1>
            <p class="text-gray-500 mt-2">
                Tu asistencia está confirmada.
                @if($guest->plus_ones > 0)
                    Estarás con {{ $guest->plus_ones }} acompañante{{ $guest->plus_ones > 1 ? 's' : '' }}.
                @endif
            </p>
        @else
            <div class="text-6xl mb-4">💌</div>
            <h1 class="text-2xl font-bold text-gray-900">Gracias por avisarnos</h1>
            <p class="text-gray-500 mt-2">
                Lamentamos que no puedas acompañarnos, {{ $guest->name }}.
            </p>
        @endif

        <div class="mt-6 bg-gray-50 rounded-xl p-4 text-sm text-gray-600">
            <p class="font-medium">{{ $guest->event->name }}</p>
            <p class="mt-1">{{ $guest->event->event_date->translatedFormat('d \d\e F \d\e Y') }}</p>
            @if($guest->event->venue_name)
                <p class="mt-1">{{ $guest->event->venue_name }}</p>
            @endif
        </div>

        <a href="{{ route('rsvp.show', $guest->token) }}"
           class="mt-6 inline-block text-sm text-indigo-600 hover:underline">
            Cambiar respuesta
        </a>

    </div>
</div>
@endsection
