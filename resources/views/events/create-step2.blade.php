@extends('layouts.app')

@section('title', 'Nuevo evento — Elige plantilla')

@section('content')
<div class="max-w-4xl mx-auto">

    @include('events._wizard-steps', ['current' => 2])

    <div class="flex items-center gap-3 mt-6 mb-2">
        <span class="text-2xl">{{ $eventType->icon }}</span>
        <h1 class="text-2xl font-bold">Elige una plantilla para {{ $eventType->name }}</h1>
    </div>
    <p class="text-gray-500 text-sm mb-8">
        Puedes cambiarla después.
        <a href="{{ route('events.create') }}" class="text-indigo-500 hover:underline">← Cambiar tipo</a>
    </p>

    @if($templates->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <p>No hay plantillas disponibles para este tipo aún.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($templates as $template)
                <a href="{{ route('events.create-with-template', $template) }}"
                   class="group border-2 border-gray-200 hover:border-indigo-400 rounded-2xl overflow-hidden transition hover:shadow-md">

                    {{-- Thumbnail --}}
                    <div class="aspect-[3/4] bg-gray-100 overflow-hidden relative">
                        @if($template->thumbnail_url)
                            <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            {{-- Preview de colores de la plantilla --}}
                            <div class="w-full h-full flex items-center justify-center"
                                 style="background: {{ $template->default_colors['background'] ?? '#f9fafb' }}">
                                <div class="text-center px-4">
                                    <div class="w-12 h-12 rounded-full mx-auto mb-3"
                                         style="background: {{ $template->default_colors['primary'] ?? '#6366f1' }}"></div>
                                    <p class="text-xs font-medium"
                                       style="color: {{ $template->default_colors['text'] ?? '#111827' }}">
                                        {{ $template->name }}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-indigo-600/0 group-hover:bg-indigo-600/10 transition flex items-end p-3">
                            <span class="opacity-0 group-hover:opacity-100 transition bg-indigo-600 text-white text-xs font-medium px-3 py-1.5 rounded-full">
                                Usar esta plantilla
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="font-semibold text-sm text-gray-800">{{ $template->name }}</p>
                        {{-- Paleta de colores --}}
                        @if($template->default_colors)
                            <div class="flex gap-1.5 mt-2">
                                @foreach(array_values($template->default_colors) as $color)
                                    <div class="w-4 h-4 rounded-full border border-white shadow-sm"
                                         style="background: {{ $color }}"></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
