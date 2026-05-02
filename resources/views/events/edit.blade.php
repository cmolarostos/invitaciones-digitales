@extends('layouts.app')

@section('title', 'Editar evento')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Editar evento</h1>

    <form method="POST" action="{{ route('events.update', $event) }}" class="bg-white border border-gray-200 rounded-lg p-6">
        @csrf
        @method('PUT')
        @include('events._form')
        <div class="mt-6 flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded">
                Guardar cambios
            </button>
            <a href="{{ route('events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">
                Cancelar
            </a>
        </div>
    </form>

    {{-- Zona peligrosa --}}
    <div class="mt-8 border border-red-200 rounded-lg p-5 bg-red-50">
        <h3 class="text-sm font-semibold text-red-700 mb-2">Zona peligrosa</h3>
        <p class="text-xs text-red-600 mb-3">
            El evento se moverá a la papelera. Podrás recuperarlo desde el listado.
        </p>
        <form method="POST" action="{{ route('events.destroy', $event) }}"
              onsubmit="return confirm('¿Eliminar este evento?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-4 py-2 rounded">
                Eliminar evento
            </button>
        </form>
    </div>
</div>
@endsection
