@extends('layouts.app')

@section('title', 'Nuevo evento — Detalles')

@section('content')
<div class="max-w-2xl mx-auto">

    @include('events._wizard-steps', ['current' => 3])

    <div class="flex items-center gap-3 mt-6 mb-6">
        <h1 class="text-2xl font-bold">Detalles del evento</h1>
        <span class="text-xs bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-full px-3 py-1">
            {{ $template->name }}
        </span>
    </div>

    <form method="POST" action="{{ route('events.store') }}"
          class="bg-white border border-gray-200 rounded-2xl p-6">
        @csrf
        <input type="hidden" name="template_id" value="{{ $template->id }}">

        @include('events._form', ['event' => null, 'templates' => collect()])

        <div class="mt-6 flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg text-sm transition">
                Crear evento
            </button>
            <a href="{{ route('events.select-template', ['event_type' => $template->eventType->slug ?? '']) }}"
               class="text-sm text-gray-500 hover:text-gray-700 py-2.5">
                ← Cambiar plantilla
            </a>
        </div>
    </form>

</div>
@endsection
