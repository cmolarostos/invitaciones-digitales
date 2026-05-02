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

</div>
