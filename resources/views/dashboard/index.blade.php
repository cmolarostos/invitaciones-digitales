@extends('layouts.app')

@section('title', 'Dashboard — Invitaciones Digitales')

@section('content')

{{-- ── Encabezado ──────────────────────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-0.5">Resumen de confirmaciones de tus eventos</p>
    </div>
    <a href="{{ route('events.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo evento
    </a>
</div>

{{-- ── Cards de totales ─────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">

    {{-- Total eventos --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col gap-1">
        <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Eventos</span>
        <span class="text-3xl font-bold text-gray-900">{{ $activeEvents->count() }}</span>
    </div>

    {{-- Total invitados --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex flex-col gap-1">
        <span class="text-xs font-medium text-gray-400 uppercase tracking-wide">Invitados</span>
        <span class="text-3xl font-bold text-gray-900">{{ $totalGuests }}</span>
    </div>

    {{-- Confirmados --}}
    <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-4 flex flex-col gap-1">
        <span class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Confirmados</span>
        <span class="text-3xl font-bold text-emerald-700">{{ $totalConfirmed }}</span>
        <span class="text-xs text-emerald-500">{{ $totalAttendees }} asistentes totales</span>
    </div>

    {{-- Declinados --}}
    <div class="bg-red-50 rounded-xl border border-red-200 p-4 flex flex-col gap-1">
        <span class="text-xs font-medium text-red-500 uppercase tracking-wide">Declinados</span>
        <span class="text-3xl font-bold text-red-600">{{ $totalDeclined }}</span>
    </div>

    {{-- Pendientes --}}
    <div class="bg-amber-50 rounded-xl border border-amber-200 p-4 flex flex-col gap-1">
        <span class="text-xs font-medium text-amber-600 uppercase tracking-wide">Pendientes</span>
        <span class="text-3xl font-bold text-amber-700">{{ $totalPending }}</span>
    </div>

</div>

{{-- ── Grid principal: eventos + actividad reciente ────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Columna izquierda: eventos ──────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-4">
        <h2 class="text-base font-semibold text-gray-700">Mis eventos</h2>

        @forelse ($eventStats as $stat)
        @php $event = $stat['event']; @endphp
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-200 transition">

            {{-- Header evento --}}
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="flex-1 min-w-0">
                    <a href="{{ route('events.show', $event) }}"
                       class="font-semibold text-gray-900 hover:text-indigo-600 truncate block">
                        {{ $event->name }}
                    </a>
                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-400">
                        @if ($event->event_date)
                            <span>{{ $event->event_date->translatedFormat('d M Y') }}</span>
                        @endif
                        @if ($event->venue_name)
                            <span>· {{ $event->venue_name }}</span>
                        @endif
                    </div>
                </div>

                {{-- Badge estado --}}
                @if ($event->status === 'published')
                    <span class="shrink-0 text-xs bg-emerald-100 text-emerald-700 font-medium px-2 py-0.5 rounded-full">Publicado</span>
                @else
                    <span class="shrink-0 text-xs bg-gray-100 text-gray-500 font-medium px-2 py-0.5 rounded-full">Borrador</span>
                @endif
            </div>

            @if ($stat['total'] > 0)
            {{-- Barra de progreso RSVP --}}
            <div class="mb-3">
                <div class="flex h-2.5 rounded-full overflow-hidden bg-gray-100">
                    @if ($stat['confirmed_pct'] > 0)
                    <div class="bg-emerald-400 transition-all"
                         style="width: {{ $stat['confirmed_pct'] }}%"
                         title="Confirmados {{ $stat['confirmed_pct'] }}%"></div>
                    @endif
                    @if ($stat['declined_pct'] > 0)
                    <div class="bg-red-400 transition-all"
                         style="width: {{ $stat['declined_pct'] }}%"
                         title="Declinados {{ $stat['declined_pct'] }}%"></div>
                    @endif
                    @if ($stat['pending_pct'] > 0)
                    <div class="bg-amber-200 transition-all"
                         style="width: {{ $stat['pending_pct'] }}%"
                         title="Pendientes {{ $stat['pending_pct'] }}%"></div>
                    @endif
                </div>
            </div>

            {{-- Números --}}
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                    {{ $stat['confirmed'] }} confirmados
                    @if ($stat['attendees'] !== $stat['confirmed'])
                        <span class="text-gray-400">({{ $stat['attendees'] }} asistentes)</span>
                    @endif
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span>
                    {{ $stat['declined'] }} declinados
                </span>
                <span class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-amber-300 inline-block"></span>
                    {{ $stat['pending'] }} pendientes
                </span>
            </div>
            @else
            <p class="text-xs text-gray-400 italic">Sin invitados aún.
                <a href="{{ route('events.guests.index', $event) }}" class="text-indigo-500 hover:underline">Agregar invitados</a>
            </p>
            @endif

            {{-- Acciones rápidas --}}
            <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('events.guests.index', $event) }}"
                   class="text-xs text-indigo-600 hover:underline">Invitados</a>
                <a href="{{ route('events.edit', $event) }}"
                   class="text-xs text-gray-400 hover:text-gray-700">Editar</a>
                @if ($event->status === 'published')
                <a href="{{ $event->publicUrl() }}" target="_blank"
                   class="text-xs text-gray-400 hover:text-gray-700 ml-auto flex items-center gap-1">
                    Ver invitación
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-dashed border-gray-300 p-10 text-center">
            <p class="text-gray-400 text-sm mb-3">Aún no tienes eventos</p>
            <a href="{{ route('events.create') }}"
               class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Crear primer evento
            </a>
        </div>
        @endforelse

        @if ($activeEvents->count() > 0)
        <div class="text-center pt-2">
            <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:underline">
                Ver todos los eventos →
            </a>
        </div>
        @endif
    </div>

    {{-- ── Columna derecha: actividad reciente ─────────────────────────────── --}}
    <div>
        <h2 class="text-base font-semibold text-gray-700 mb-4">Actividad reciente</h2>

        <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
            @forelse ($recentActivity as $guest)
            <div class="px-4 py-3 flex items-start gap-3">
                {{-- Icono --}}
                @if ($guest->rsvp_status === 'confirmed')
                <div class="mt-0.5 w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                @else
                <div class="mt-0.5 w-7 h-7 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                @endif

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $guest->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $guest->rsvp_status === 'confirmed' ? 'Confirmó' : 'Declinó' }}
                        @if ($guest->plus_ones > 0)
                            · +{{ $guest->plus_ones }} acompañante{{ $guest->plus_ones > 1 ? 's' : '' }}
                        @endif
                    </p>
                </div>

                <span class="text-xs text-gray-300 whitespace-nowrap shrink-0 mt-0.5">
                    {{ $guest->rsvp_at->diffForHumans() }}
                </span>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <p class="text-sm text-gray-400">Sin actividad aún</p>
                <p class="text-xs text-gray-300 mt-1">Las respuestas de tus invitados aparecerán aquí</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
