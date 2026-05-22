{{-- Partial reutilizable para create y edit --}}

<div class="grid gap-5">

    {{-- Nombre --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nombre del evento *</label>
        <input type="text" name="name" value="{{ old('name', $event->name ?? '') }}"
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
               required>
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Plantilla: solo muestra selector en edit (en create viene fijo del wizard) --}}
    @isset($eventTypes)
        <div>
            <label class="block text-sm font-medium mb-1">Plantilla *</label>
            <select name="template_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    required>
                <option value="">— Selecciona —</option>
                @foreach ($eventTypes as $type)
                    <optgroup label="{{ $type->icon }} {{ $type->name }}">
                        @foreach ($type->templates as $tmpl)
                            <option value="{{ $tmpl->id }}"
                                {{ old('template_id', $event->template_id ?? '') == $tmpl->id ? 'selected' : '' }}>
                                {{ $tmpl->name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('template_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    @endisset

    {{-- Fecha y hora --}}
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Fecha *</label>
            <input type="date" name="event_date"
                   value="{{ old('event_date', isset($event) ? $event->event_date->format('Y-m-d') : '') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                   required>
            @error('event_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Hora</label>
            <input type="time" name="event_time"
                   value="{{ old('event_time', $event->event_time ?? '') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            @error('event_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Lugar --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nombre del lugar</label>
        <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name ?? '') }}"
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        @error('venue_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Dirección</label>
        <input type="text" name="venue_address" value="{{ old('venue_address', $event->venue_address ?? '') }}"
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        @error('venue_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">URL de Google Maps</label>
        <input type="url" name="venue_maps_url" value="{{ old('venue_maps_url', $event->venue_maps_url ?? '') }}"
               placeholder="https://maps.google.com/..."
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        @error('venue_maps_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Dress code --}}
    <div>
        <label class="block text-sm font-medium mb-1">Código de vestimenta</label>
        <input type="text" name="dress_code" value="{{ old('dress_code', $event->dress_code ?? '') }}"
               placeholder="Ej. Formal, Semi-formal…"
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        @error('dress_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Notas --}}
    <div>
        <label class="block text-sm font-medium mb-1">Notas para los invitados</label>
        <textarea name="notes" rows="3"
                  class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('notes', $event->notes ?? '') }}</textarea>
        @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Itinerario --}}
    <div>
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-medium">Itinerario del evento</label>
            <button type="button" id="add-itinerary-item"
                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar paso
            </button>
        </div>
        <p class="text-xs text-gray-400 mb-3">Define los momentos clave del evento que aparecerán en la invitación.</p>

        <div id="itinerary-list" class="space-y-2">
            @php
                $itineraryItems = old('itinerary', $event->itinerary ?? []);
            @endphp
            @forelse($itineraryItems as $i => $item)
                <div class="itinerary-item flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex flex-col items-center pt-1 text-gray-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-[90px_1fr] gap-2">
                        <input type="time" name="itinerary[{{ $i }}][time]"
                               value="{{ $item['time'] ?? '' }}"
                               class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <input type="text" name="itinerary[{{ $i }}][title]"
                               value="{{ $item['title'] ?? '' }}"
                               placeholder="Título del momento *"
                               class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <input type="text" name="itinerary[{{ $i }}][description]"
                               value="{{ $item['description'] ?? '' }}"
                               placeholder="Descripción opcional"
                               class="sm:col-span-2 border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <button type="button" class="remove-itinerary-item mt-0.5 text-gray-400 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @empty
                {{-- empty state handled by JS --}}
            @endforelse
        </div>

        @if(count($itineraryItems) === 0)
            <p id="itinerary-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg">
                Sin pasos aún. Haz clic en "Agregar paso" para comenzar.
            </p>
        @else
            <p id="itinerary-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg hidden">
                Sin pasos aún. Haz clic en "Agregar paso" para comenzar.
            </p>
        @endif
    </div>

</div>

<script>
(function () {
    const list    = document.getElementById('itinerary-list');
    const addBtn  = document.getElementById('add-itinerary-item');
    const empty   = document.getElementById('itinerary-empty');

    function reindex() {
        list.querySelectorAll('.itinerary-item').forEach((row, i) => {
            row.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/itinerary\[\d+\]/, `itinerary[${i}]`);
            });
        });
        empty.classList.toggle('hidden', list.children.length > 0);
    }

    function makeRow(index) {
        const div = document.createElement('div');
        div.className = 'itinerary-item flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-lg p-3';
        div.innerHTML = `
            <div class="flex flex-col items-center pt-1 text-gray-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-[90px_1fr] gap-2">
                <input type="time" name="itinerary[${index}][time]"
                       class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <input type="text" name="itinerary[${index}][title]"
                       placeholder="Título del momento *"
                       class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <input type="text" name="itinerary[${index}][description]"
                       placeholder="Descripción opcional"
                       class="sm:col-span-2 border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <button type="button" class="remove-itinerary-item mt-0.5 text-gray-400 hover:text-red-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>`;
        div.querySelector('.remove-itinerary-item').addEventListener('click', function () {
            div.remove();
            reindex();
        });
        return div;
    }

    addBtn.addEventListener('click', function () {
        const index = list.children.length;
        const row   = makeRow(index);
        list.appendChild(row);
        row.querySelector('input[type="time"]').focus();
        reindex();
    });

    list.querySelectorAll('.remove-itinerary-item').forEach(btn => {
        btn.addEventListener('click', function () {
            btn.closest('.itinerary-item').remove();
            reindex();
        });
    });
})();
</script>
