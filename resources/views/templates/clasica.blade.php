@extends('layouts.public')

@section('title', $event->name)

@section('content')
<div class="min-h-screen bg-stone-50 flex flex-col items-center justify-center px-4 py-16 text-center">

    {{-- Portada --}}
    @if($cover = $event->coverPhoto())
        <img src="{{ $cover->url }}" alt="{{ $event->name }}"
             class="w-full max-w-lg rounded-2xl shadow-md mb-10 object-cover max-h-80">
    @endif

    <p class="text-sm uppercase tracking-widest text-stone-400 mb-2">Te invitamos a celebrar</p>
    <h1 class="text-4xl font-serif font-bold text-stone-800">{{ $event->name }}</h1>

    <div class="my-8 flex flex-col gap-2 text-stone-600 text-sm">
        <p class="text-lg font-medium">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
        </p>
        @if($event->event_time)
            <p>{{ $event->event_time }} hrs</p>
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
           class="mb-6 text-sm text-indigo-600 hover:underline">
            📍 Ver en Google Maps
        </a>
    @endif

    @if($event->dress_code)
        <p class="text-sm text-stone-500 mb-6">
            Vestimenta: <strong>{{ $event->dress_code }}</strong>
        </p>
    @endif

    @if($event->notes)
        <p class="text-sm text-stone-500 max-w-sm mb-8">{{ $event->notes }}</p>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="grid grid-cols-3 gap-2 max-w-lg w-full mb-10">
            @foreach($event->photos->skip(1)->take(6) as $photo)
                <img src="{{ $photo->url }}" alt=""
                     class="w-full aspect-square object-cover rounded-lg">
            @endforeach
        </div>
    @endif

</div>
@endsection
