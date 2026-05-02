@extends('layouts.app')

@section('title', 'Nuevo evento — Tipo de evento')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Wizard steps --}}
    @include('events._wizard-steps', ['current' => 1])

    <h1 class="text-2xl font-bold mb-2 mt-6">¿Qué tipo de evento vas a celebrar?</h1>
    <p class="text-gray-500 text-sm mb-8">Elige el tipo para ver las plantillas disponibles.</p>

    <form method="GET" action="{{ route('events.select-template') }}">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            @foreach ($eventTypes as $type)
                <label class="cursor-pointer group">
                    <input type="radio" name="event_type" value="{{ $type->slug }}"
                           class="sr-only peer" required>
                    <div class="border-2 border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50
                                rounded-2xl p-5 text-center transition hover:border-gray-300 hover:shadow-sm">
                        <div class="text-4xl mb-3">{{ $type->icon }}</div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $type->name }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $type->templates_count }}
                            {{ Str::plural('plantilla', $type->templates_count) }}
                        </p>
                    </div>
                </label>
            @endforeach
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition">
                Ver plantillas →
            </button>
            <a href="{{ route('events.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 py-2.5">
                Cancelar
            </a>
        </div>
    </form>

</div>
@endsection
