@extends('layouts.public')

@section('title', $event->name)

@section('content')
<div class="min-h-screen bg-stone-50 flex flex-col items-center justify-center px-4 py-16 text-center">

    {{-- Portada --}}
    @if($cover = $event->coverPhoto())
        <img src="{{ $cover->url }}" alt="{{ $event->name }}"
             class="fade-up delay-1 w-full max-w-lg rounded-2xl shadow-md mb-10 object-cover max-h-80">
    @endif

    <p class="fade-up delay-1 text-sm uppercase tracking-widest text-stone-400 mb-2">Te invitamos a celebrar</p>
    <h1 class="fade-up delay-2 text-4xl font-serif font-bold text-stone-800">{{ $event->name }}</h1>

    <div class="fade-up delay-3 my-8 flex flex-col gap-2 text-stone-600 text-sm">
        <p class="text-lg font-medium">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
        </p>
        @if($event->event_time)
            <p>{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
        @endif
        @if($event->venue_name)
            <p class="font-medium">{{ $event->venue_name }}</p>
        @endif
        @if($event->venue_address)
            <p>{{ $event->venue_address }}</p>
        @endif
    </div>

    @if($event->venue_maps_url)
        <a href="{{ $event->venue_maps_url }}" target="_blank"
           class="fade-up delay-4 mb-6 text-sm text-indigo-600 hover:underline">
            📍 Ver en Google Maps
        </a>
    @endif

    @if($event->dress_code)
        <div class="fade-up delay-5 text-sm text-stone-500 mb-6">
            <p>Vestimenta: <strong>{{ $event->dress_code }}</strong></p>
            @if($event->dress_code_colors)
                <div style="margin-top:12px; text-align:center;">
                    <p style="font-size:0.7rem; letter-spacing:0.15em; text-transform:uppercase; color:#a8a29e; margin-bottom:8px;">Por favor evita estos colores</p>
                    <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                        @foreach($event->dress_code_colors as $color)
                            <div title="{{ $color['label'] ?? '' }}"
                                 style="width:26px;height:26px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.08);position:relative;">
                                <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #78716c;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#78716c 50%,transparent calc(50% + 0.5px));display:block;"></span>
                            </div>
                        @endforeach
                    </div>
                    <p style="font-size:0.7rem; color:#78716c; margin-top:8px;">Reservados para la festejada</p>
                    @if($event->dress_code_colors_note)
                        <p style="font-size:0.72rem; color:#a8a29e; margin-top:4px; font-style:italic;">{{ $event->dress_code_colors_note }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    @if($event->notes)
        <p class="fade-up delay-5 text-sm text-stone-500 max-w-sm mb-8">{{ $event->notes }}</p>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-6 grid grid-cols-3 gap-2 max-w-lg w-full mb-10">
            @foreach($event->photos->skip(1)->take(6) as $photo)
                <img src="{{ $photo->url }}" alt=""
                     class="w-full aspect-square object-cover rounded-lg">
            @endforeach
        </div>
    @endif

</div>
@endsection
