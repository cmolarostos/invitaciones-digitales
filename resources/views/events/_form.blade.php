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
                   value="{{ old('event_time', isset($event) ? substr($event->event_time ?? '', 0, 5) : '') }}"
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
    <div class="space-y-3">
        <div>
            <label class="block text-sm font-medium mb-1">Código de vestimenta</label>
            <input type="text" name="dress_code" value="{{ old('dress_code', $event->dress_code ?? '') }}"
                   placeholder="Ej. Formal, Semi-formal…"
                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            @error('dress_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Instrucciones por género --}}
        @php
            $hasDcDetails = old('dress_code_men', $event->dress_code_men ?? null)
                         || old('dress_code_women', $event->dress_code_women ?? null);
            $hasDcColors  = count(old('dress_code_colors', $event->dress_code_colors ?? [])) > 0;
        @endphp

        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="dc-details-toggle"
                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
                   {{ $hasDcDetails ? 'checked' : '' }}>
            <span class="text-sm text-gray-600">Agregar instrucciones por género</span>
        </label>

        <div id="dc-details" class="{{ $hasDcDetails ? '' : 'hidden' }} grid grid-cols-1 sm:grid-cols-2 gap-3 pl-6">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Caballeros</label>
                <textarea name="dress_code_men" rows="2" placeholder="Ej. Traje oscuro, corbata…"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('dress_code_men', $event->dress_code_men ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Damas</label>
                <textarea name="dress_code_women" rows="2" placeholder="Ej. Vestido largo, tonos sobrios…"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('dress_code_women', $event->dress_code_women ?? '') }}</textarea>
            </div>
        </div>

        {{-- Paleta de colores a evitar --}}
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" id="dc-colors-toggle"
                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
                   {{ $hasDcColors ? 'checked' : '' }}>
            <span class="text-sm text-gray-600">Indicar colores a evitar</span>
        </label>

        <div id="dc-colors" class="{{ $hasDcColors ? '' : 'hidden' }} pl-6">
            <p class="text-xs text-gray-400 mb-2">Agrega los colores que los invitados deben evitar usar.</p>
            <div id="dc-color-list" class="flex flex-wrap gap-2 mb-2">
                @foreach(old('dress_code_colors', $event->dress_code_colors ?? []) as $i => $color)
                    <div class="dc-color-item flex items-center gap-1 border border-gray-200 rounded-lg px-2 py-1 bg-gray-50">
                        <input type="color" name="dress_code_colors[{{ $i }}][hex]"
                               value="{{ $color['hex'] }}"
                               class="w-8 h-8 rounded cursor-pointer border-0 p-0 bg-transparent">
                        <input type="text" name="dress_code_colors[{{ $i }}][label]"
                               value="{{ $color['label'] ?? '' }}"
                               placeholder="Nombre" maxlength="20"
                               class="w-24 border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-400">
                        <button type="button" class="remove-dc-color text-gray-400 hover:text-red-500 transition text-sm leading-none">✕</button>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-dc-color"
                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar color
            </button>
        </div>
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

        @if(count($itineraryItems ?? []) === 0)
            <p id="itinerary-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg">
                Sin pasos aún. Haz clic en "Agregar paso" para comenzar.
            </p>
        @else
            <p id="itinerary-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg hidden">
                Sin pasos aún. Haz clic en "Agregar paso" para comenzar.
            </p>
        @endif
    </div>

    {{-- Mesa de regalos --}}
    <div>
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-medium">Mesa de regalos</label>
            <button type="button" id="add-gift-item"
                    class="text-xs text-indigo-600 hover:text-indigo-800 font-medium flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Agregar opción
            </button>
        </div>
        <p class="text-xs text-gray-400 mb-3">Si no agregas ninguna opción, la sección no se mostrará en la invitación.</p>

        {{-- Encabezados configurables --}}
        <div class="grid grid-cols-1 gap-2 mb-3">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Título de la sección</label>
                <input type="text" name="gifts_title"
                       value="{{ old('gifts_title', $event->gifts_title ?? '') }}"
                       placeholder="Tu presencia es el mejor regalo"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Subtítulo</label>
                <input type="text" name="gifts_subtitle"
                       value="{{ old('gifts_subtitle', $event->gifts_subtitle ?? '') }}"
                       placeholder="Si deseas obsequiar algo más, aquí encontrarás opciones para hacerlo con cariño."
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
        </div>

        {{-- Lista de opciones --}}
        <div id="gifts-list" class="space-y-2">
            @php $giftsItems = old('gifts', $event->gifts ?? []); @endphp
            @forelse($giftsItems as $i => $gift)
                <div class="gift-item flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <input type="text" name="gifts[{{ $i }}][title]"
                               value="{{ $gift['title'] ?? '' }}"
                               placeholder="Nombre (ej. Liverpool) *"
                               class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <input type="text" name="gifts[{{ $i }}][description]"
                               value="{{ $gift['description'] ?? '' }}"
                               placeholder="Descripción (ej. Mesa de regalos)"
                               class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <input type="url" name="gifts[{{ $i }}][url]"
                               value="{{ $gift['url'] ?? '' }}"
                               placeholder="Link (opcional)"
                               class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <button type="button" class="remove-gift-item mt-0.5 text-gray-400 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @empty
                {{-- vacío, JS lo maneja --}}
            @endforelse
        </div>

        @if(count($giftsItems) === 0)
            <p id="gifts-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg">
                Sin opciones aún. La sección de mesa de regalos estará oculta.
            </p>
        @else
            <p id="gifts-empty" class="text-sm text-gray-400 text-center py-4 border border-dashed border-gray-200 rounded-lg hidden">
                Sin opciones aún. La sección de mesa de regalos estará oculta.
            </p>
        @endif
    </div>

    {{-- Paleta de colores --}}
    @php
        $paletteTemplate = $event->template ?? $template ?? null;
        $palettes = $paletteTemplate?->color_palettes ?? [];
        $savedColors = $event->custom_colors ?? null;
        $savedColorsJson = $savedColors ? json_encode($savedColors) : '';
    @endphp
    @if(count($palettes) > 0)
    <div>
        <label class="block text-sm font-medium mb-3">Colores</label>
        <div class="flex flex-wrap gap-3" id="palette-list">
            @foreach($palettes as $i => $palette)
                @php
                    $isSelected = $savedColorsJson && json_encode($palette['vars']) === json_encode($savedColors);
                @endphp
                <button type="button"
                        class="palette-card relative rounded-2xl overflow-hidden cursor-pointer transition-all border-2
                               {{ $isSelected ? 'border-gray-800 shadow-md' : 'border-transparent hover:border-gray-300' }}"
                        style="width:68px;height:68px;"
                        data-vars="{{ json_encode($palette['vars']) }}"
                        data-name="{{ $palette['name'] }}"
                        title="{{ $palette['name'] }}">
                    {{-- Mini preview 2x2 --}}
                    <div class="grid grid-cols-2 w-full h-full">
                        <div style="background:{{ $palette['preview'][0] }}"></div>
                        <div style="background:{{ $palette['preview'][1] }}"></div>
                        <div style="background:{{ $palette['preview'][2] }}"></div>
                        <div style="background:{{ $palette['preview'][3] }}"></div>
                    </div>
                    {{-- Checkmark si está seleccionado --}}
                    <div class="palette-check absolute inset-0 flex items-center justify-center bg-black/20
                                {{ $isSelected ? '' : 'hidden' }}">
                        <svg class="w-6 h-6 text-white drop-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </button>
            @endforeach
        </div>
        @php
            $selectedName = '';
            foreach ($palettes as $p) {
                if ($savedColors && json_encode($p['vars']) === json_encode($savedColors)) {
                    $selectedName = $p['name'];
                    break;
                }
            }
        @endphp
        <p id="palette-name" class="text-sm text-gray-500 mt-2">{{ $selectedName }}</p>
        <input type="hidden" name="custom_colors" id="custom-colors-input"
               value="{{ $savedColorsJson }}">
    </div>
    @endif

    {{-- Música de fondo --}}
    <div>
        <label class="block text-sm font-medium mb-1">Música de fondo</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $event->youtube_url ?? '') }}"
               placeholder="https://www.youtube.com/watch?v=..."
               class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        <p class="text-xs text-gray-400 mt-1">Pega un link de YouTube. Sonará cuando el invitado abra la invitación.</p>
        @error('youtube_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Confirmación de asistencia --}}
    <div class="border border-indigo-100 bg-indigo-50/40 rounded-lg px-4 py-3">
        <label class="flex items-start gap-3 cursor-pointer">
            <input type="checkbox" name="requires_rsvp" value="1"
                   class="mt-0.5 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
                   {{ old('requires_rsvp', $event->requires_rsvp ?? false) ? 'checked' : '' }}>
            <div>
                <span class="text-sm font-medium text-gray-800">Solicitar confirmación de asistencia</span>
                <p class="text-xs text-gray-500 mt-0.5">
                    Se mostrará una sección de RSVP en la invitación para que los invitados confirmen si asistirán.
                </p>
            </div>
        </label>
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

// ── Mesa de regalos ──
(function () {
    const list   = document.getElementById('gifts-list');
    const addBtn = document.getElementById('add-gift-item');
    const empty  = document.getElementById('gifts-empty');
    if (!list || !addBtn) return;

    function reindex() {
        list.querySelectorAll('.gift-item').forEach((row, i) => {
            row.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/gifts\[\d+\]/, `gifts[${i}]`);
            });
        });
        empty.classList.toggle('hidden', list.children.length > 0);
    }

    function makeRow(index) {
        const div = document.createElement('div');
        div.className = 'gift-item flex items-start gap-2 bg-gray-50 border border-gray-200 rounded-lg p-3';
        div.innerHTML = `
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-2">
                <input type="text" name="gifts[${index}][title]" placeholder="Nombre (ej. Liverpool) *"
                       class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <input type="text" name="gifts[${index}][description]" placeholder="Descripción (ej. Mesa de regalos)"
                       class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <input type="url" name="gifts[${index}][url]" placeholder="Link (opcional)"
                       class="border border-gray-300 rounded px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
            <button type="button" class="remove-gift-item mt-0.5 text-gray-400 hover:text-red-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>`;
        div.querySelector('.remove-gift-item').addEventListener('click', () => { div.remove(); reindex(); });
        return div;
    }

    addBtn.addEventListener('click', () => {
        const row = makeRow(list.children.length);
        list.appendChild(row);
        row.querySelector('input').focus();
        reindex();
    });

    list.querySelectorAll('.remove-gift-item').forEach(btn => {
        btn.addEventListener('click', () => { btn.closest('.gift-item').remove(); reindex(); });
    });
})();

// ── Paleta de colores ──
(function () {
    const cards  = document.querySelectorAll('.palette-card');
    const input  = document.getElementById('custom-colors-input');
    const label  = document.getElementById('palette-name');
    if (!cards.length) return;

    cards.forEach(card => {
        card.addEventListener('click', function () {
            cards.forEach(c => {
                c.classList.replace('border-gray-800', 'border-transparent');
                c.classList.remove('shadow-md');
                c.querySelector('.palette-check').classList.add('hidden');
            });
            card.classList.replace('border-transparent', 'border-gray-800');
            card.classList.add('shadow-md');
            card.querySelector('.palette-check').classList.remove('hidden');
            input.value = card.dataset.vars;
            if (label) label.textContent = card.dataset.name;
        });
    });
})();

// ── Dress code: instrucciones por género ──
(function () {
    const toggle  = document.getElementById('dc-details-toggle');
    const details = document.getElementById('dc-details');
    if (!toggle) return;
    toggle.addEventListener('change', () => details.classList.toggle('hidden', !toggle.checked));
})();

// ── Dress code: paleta de colores ──
(function () {
    const toggle   = document.getElementById('dc-colors-toggle');
    const section  = document.getElementById('dc-colors');
    const addBtn   = document.getElementById('add-dc-color');
    const list     = document.getElementById('dc-color-list');
    if (!toggle) return;

    toggle.addEventListener('change', () => section.classList.toggle('hidden', !toggle.checked));

    function reindexColors() {
        list.querySelectorAll('.dc-color-item').forEach((item, i) => {
            item.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/dress_code_colors\[\d+\]/, `dress_code_colors[${i}]`);
            });
        });
    }

    function makeColorItem(index) {
        const div = document.createElement('div');
        div.className = 'dc-color-item flex items-center gap-1 border border-gray-200 rounded-lg px-2 py-1 bg-gray-50';
        div.innerHTML = `
            <input type="color" name="dress_code_colors[${index}][hex]" value="#cccccc"
                   class="w-8 h-8 rounded cursor-pointer border-0 p-0 bg-transparent">
            <input type="text" name="dress_code_colors[${index}][label]"
                   placeholder="Nombre" maxlength="20"
                   class="w-24 border border-gray-200 rounded px-2 py-1 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-400">
            <button type="button" class="remove-dc-color text-gray-400 hover:text-red-500 transition text-sm leading-none">✕</button>`;
        div.querySelector('.remove-dc-color').addEventListener('click', () => { div.remove(); reindexColors(); });
        return div;
    }

    addBtn.addEventListener('click', () => {
        const item = makeColorItem(list.children.length);
        list.appendChild(item);
        reindexColors();
    });

    list.querySelectorAll('.remove-dc-color').forEach(btn => {
        btn.addEventListener('click', () => { btn.closest('.dc-color-item').remove(); reindexColors(); });
    });
})();
</script>
