@extends('layouts.public')

@section('title', 'Confirmar asistencia — ' . $guest->event->name)

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <h1 class="text-2xl font-bold text-center text-gray-900">
            {{ $guest->event->name }}
        </h1>
        <p class="text-center text-gray-500 text-sm mt-1">
            {{ $guest->event->event_date->translatedFormat('d \d\e F \d\e Y') }}
            @if($guest->event->event_time)
                · {{ $guest->event->event_time }}
            @endif
        </p>

        <div class="border-t border-gray-100 my-6"></div>

        <p class="text-center text-gray-700 mb-6">
            Hola, <strong>{{ $guest->name }}</strong>.<br>
            ¿Confirmas tu asistencia?
        </p>

        @if($guest->rsvp_status !== 'pending')
            <div class="text-center text-sm
                @if($guest->rsvp_status === 'confirmed') text-green-700 bg-green-50 @else text-red-600 bg-red-50 @endif
                rounded-lg px-4 py-3 mb-6">
                Ya respondiste: <strong>{{ $guest->rsvp_status === 'confirmed' ? 'Confirmado' : 'Declinado' }}</strong>.
                Puedes actualizar tu respuesta abajo.
            </div>
        @endif

        <form method="POST" action="{{ route('rsvp.confirm', $guest->token) }}" class="space-y-5"
              id="rsvp-form">
            @csrf

            {{-- Asistencia --}}
            <div class="grid grid-cols-2 gap-3">
                <label class="cursor-pointer">
                    <input type="radio" name="rsvp_status" value="confirmed" class="sr-only peer"
                           {{ old('rsvp_status', $guest->rsvp_status) === 'confirmed' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50
                                rounded-xl p-4 text-center transition">
                        <span class="text-2xl">🎉</span>
                        <p class="text-sm font-medium mt-1">Sí, asistiré</p>
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="rsvp_status" value="declined" class="sr-only peer"
                           {{ old('rsvp_status', $guest->rsvp_status) === 'declined' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-200 peer-checked:border-red-400 peer-checked:bg-red-50
                                rounded-xl p-4 text-center transition">
                        <span class="text-2xl">😔</span>
                        <p class="text-sm font-medium mt-1">No podré ir</p>
                    </div>
                </label>
            </div>
            @error('rsvp_status') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror

            {{-- Acompañantes (solo si confirma) --}}
            <div id="plus-ones-field">
                <label class="block text-sm font-medium mb-1">¿Cuántos acompañantes traes?</label>
                <select name="plus_ones"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @for ($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('plus_ones', $guest->plus_ones) == $i ? 'selected' : '' }}>
                            {{ $i === 0 ? 'Solo yo' : $i . ' acompañante' . ($i > 1 ? 's' : '') }}
                        </option>
                    @endfor
                </select>
                @error('plus_ones') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mensaje --}}
            <div>
                <label class="block text-sm font-medium mb-1">Mensaje (opcional)</label>
                <textarea name="rsvp_notes" rows="2" placeholder="¿Algo que quieras decirnos?"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('rsvp_notes', $guest->rsvp_notes) }}</textarea>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl py-3">
                Enviar respuesta
            </button>
        </form>

    </div>
</div>

<script>
    const radios    = document.querySelectorAll('input[name="rsvp_status"]');
    const plusOnes  = document.getElementById('plus-ones-field');

    function toggle() {
        const checked = document.querySelector('input[name="rsvp_status"]:checked');
        plusOnes.style.display = (!checked || checked.value === 'confirmed') ? '' : 'none';
    }

    radios.forEach(r => r.addEventListener('change', toggle));
    toggle();
</script>
@endsection
