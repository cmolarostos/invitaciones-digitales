@extends('layouts.app')

@section('title', 'Nuevo evento')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Nuevo evento</h1>

    <form method="POST" action="{{ route('events.store') }}" class="bg-white border border-gray-200 rounded-lg p-6">
        @csrf
        @include('events._form')
        <div class="mt-6 flex gap-3">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded">
                Crear evento
            </button>
            <a href="{{ route('events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 py-2">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
