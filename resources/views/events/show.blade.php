@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">{{ $event->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">
            {{ $event->event_date->translatedFormat('d \d\e F \d\e Y') }}
            @if($event->event_time) · {{ $event->event_time }} @endif
        </p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('events.edit', $event) }}"
           class="text-sm border border-gray-300 rounded px-3 py-1.5 hover:bg-gray-50">
            Editar
        </a>
        @if($event->status === 'draft')
            <form method="POST" action="{{ route('events.publish', $event) }}">
                @csrf
                <button class="text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded px-3 py-1.5">
                    Publicar
                </button>
            </form>
        @else
            <a href="{{ $event->publicUrl() }}" target="_blank"
               class="text-sm bg-green-600 hover:bg-green-700 text-white rounded px-3 py-1.5">
                Ver invitación
            </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Detalles --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h2 class="font-semibold mb-3">Detalles</h2>
            <dl class="grid grid-cols-2 gap-3 text-sm">
                @if($event->venue_name)
                    <div>
                        <dt class="text-gray-500">Lugar</dt>
                        <dd>{{ $event->venue_name }}</dd>
                    </div>
                @endif
                @if($event->venue_address)
                    <div>
                        <dt class="text-gray-500">Dirección</dt>
                        <dd>{{ $event->venue_address }}</dd>
                    </div>
                @endif
                @if($event->dress_code)
                    <div>
                        <dt class="text-gray-500">Vestimenta</dt>
                        <dd>{{ $event->dress_code }}</dd>
                    </div>
                @endif
                @if($event->notes)
                    <div class="col-span-2">
                        <dt class="text-gray-500">Notas</dt>
                        <dd>{{ $event->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        {{-- Fotos --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Fotos ({{ $event->photos->count() }})</h2>
            </div>

            @if($event->photos->isNotEmpty())
                <div class="grid grid-cols-3 gap-2 mb-4">
                    @foreach ($event->photos as $photo)
                        <div class="relative group">
                            <img src="{{ $photo->url }}" alt=""
                                 class="w-full aspect-square object-cover rounded {{ $photo->is_cover ? 'ring-2 ring-indigo-500' : '' }}">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded flex items-end gap-1 p-1">
                                @unless($photo->is_cover)
                                    <form method="POST" action="{{ route('events.photos.cover', [$event, $photo]) }}">
                                        @csrf
                                        <button class="text-xs bg-white text-gray-800 rounded px-1.5 py-0.5">Portada</button>
                                    </form>
                                @endunless
                                <form method="POST" action="{{ route('events.photos.destroy', [$event, $photo]) }}"
                                      onsubmit="return confirm('¿Eliminar foto?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs bg-red-500 text-white rounded px-1.5 py-0.5">✕</button>
                                </form>
                            </div>
                            @if($photo->is_cover)
                                <span class="absolute top-1 left-1 bg-indigo-600 text-white text-xs px-1.5 py-0.5 rounded">
                                    Portada
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('events.photos.store', $event) }}"
                  enctype="multipart/form-data" class="flex items-center gap-3">
                @csrf
                <input type="file" name="photos[]" multiple accept="image/*" class="text-sm text-gray-600">
                <button class="text-sm bg-gray-100 hover:bg-gray-200 rounded px-3 py-1.5">Subir</button>
            </form>
        </div>

    </div>

    {{-- Sidebar: invitados --}}
    <div class="space-y-5">
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Invitados</h2>
                <a href="{{ route('events.guests.index', $event) }}"
                   class="text-xs text-indigo-600 hover:underline">Ver todos</a>
            </div>
            <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Total</span>
                    <span>{{ $event->guests->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Confirmados</span>
                    <span class="text-green-700">{{ $event->guests->where('rsvp_status', 'confirmed')->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pendientes</span>
                    <span class="text-yellow-600">{{ $event->guests->where('rsvp_status', 'pending')->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Declinados</span>
                    <span class="text-red-600">{{ $event->guests->where('rsvp_status', 'declined')->count() }}</span>
                </div>
            </div>
            <a href="{{ route('events.guests.index', $event) }}"
               class="mt-4 block text-center text-sm bg-gray-100 hover:bg-gray-200 rounded px-3 py-2">
                Gestionar invitados
            </a>
        </div>

        {{-- Link público --}}
        @if($event->status !== 'draft')
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h2 class="font-semibold mb-2 text-sm">Link de la invitación</h2>
                <input type="text" readonly value="{{ $event->publicUrl() }}"
                       onclick="this.select()"
                       class="w-full text-xs border border-gray-200 rounded px-2 py-1.5 bg-gray-50 cursor-pointer">
            </div>
        @endif
    </div>

</div>
@endsection
