@extends('layouts.app')

@section('title', 'Invitados — ' . $event->name)

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('events.show', $event) }}" class="text-sm text-indigo-600 hover:underline">
            ← {{ $event->name }}
        </a>
        <h1 class="text-2xl font-bold mt-1">Invitados</h1>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Lista --}}
    <div class="lg:col-span-2">
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            @if($guests->isEmpty())
                <p class="text-gray-400 text-sm text-center py-12">Aún no hay invitados.</p>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="text-left px-4 py-3">Nombre</th>
                            <th class="text-left px-4 py-3">Teléfono</th>
                            <th class="text-left px-4 py-3">RSVP</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($guests as $guest)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $guest->name }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $guest->phone }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($guest->rsvp_status === 'confirmed') bg-green-100 text-green-700
                                        @elseif($guest->rsvp_status === 'declined') bg-red-100 text-red-600
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($guest->rsvp_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form method="POST" action="{{ route('events.guests.destroy', [$event, $guest]) }}"
                                          onsubmit="return confirm('¿Eliminar a {{ $guest->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="text-xs text-red-500 hover:text-red-700">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $guests->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar: agregar / importar --}}
    <div class="space-y-5">

        {{-- Agregar uno --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h2 class="font-semibold mb-3 text-sm">Agregar invitado</h2>
            <form method="POST" action="{{ route('events.guests.store', $event) }}" class="space-y-3">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Nombre completo"
                           value="{{ old('name') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <input type="text" name="phone" placeholder="+521234567890"
                           value="{{ old('phone') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                           required>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded py-2">
                    Agregar
                </button>
            </form>
        </div>

        {{-- Importar CSV --}}
        <div class="bg-white border border-gray-200 rounded-lg p-5">
            <h2 class="font-semibold mb-1 text-sm">Importar CSV</h2>
            <p class="text-xs text-gray-400 mb-3">Formato: <code>Nombre,Teléfono</code> (sin encabezado)</p>
            <form method="POST" action="{{ route('events.guests.import', $event) }}"
                  enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="file" name="csv" accept=".csv,.txt" class="text-sm text-gray-600 w-full">
                @error('csv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <button class="w-full bg-gray-100 hover:bg-gray-200 text-sm rounded py-2">
                    Importar
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
