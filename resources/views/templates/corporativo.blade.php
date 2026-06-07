<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f7fafc; }

        .navy   { background: #1a365d; }
        .card   { background: white; border-radius: 12px; box-shadow: 0 1px 8px rgba(0,0,0,0.07); }
        .accent { color: #3182ce; }
        .accent-bg { background: #ebf4ff; }
        .accent-border { border-color: #bee3f8; }

        .timeline-item { position: relative; padding-left: 20px; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0; top: 4px;
            width: 4px; height: calc(100% + 12px);
            background: #bee3f8;
            border-radius: 2px;
        }
        .timeline-item:last-child::before { height: 16px; }

    </style>
</head>
<body>

{{-- Header navy --}}
<div class="navy fade-up delay-1">
    <div class="max-w-lg mx-auto px-6 py-10">
        <p class="text-blue-300 text-xs font-semibold uppercase tracking-widest mb-3">
            Invitación oficial
        </p>
        <h1 class="text-white text-3xl font-bold leading-snug">
            {{ $event->name }}
        </h1>
        <div class="h-0.5 w-16 bg-blue-400 mt-4 rounded"></div>
        <p class="text-blue-200 text-sm mt-3">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
            @if($event->event_time) · {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} @endif
        </p>
    </div>
</div>

<div class="max-w-lg mx-auto px-4 py-6 space-y-4">

    {{-- Fecha y hora --}}
    <div class="card p-5 fade-up delay-1">
        <div class="grid grid-cols-2 gap-4">
            <div class="accent-bg accent-border border rounded-xl p-4 text-center">
                <p class="text-xs font-semibold accent uppercase tracking-wider mb-2">Fecha</p>
                <p class="text-4xl font-bold text-gray-900">{{ $event->event_date->format('d') }}</p>
                <p class="text-sm font-semibold accent capitalize">
                    {{ $event->event_date->translatedFormat('F Y') }}
                </p>
            </div>
            <div class="accent-bg accent-border border rounded-xl p-4 text-center">
                <p class="text-xs font-semibold accent uppercase tracking-wider mb-2">Horario</p>
                @if($event->event_time)
                    <p class="text-4xl font-bold text-gray-900">
                        {{ \Carbon\Carbon::parse($event->event_time)->format('g') }}
                    </p>
                    <p class="text-sm font-semibold accent">
                        {{ \Carbon\Carbon::parse($event->event_time)->format('A') }}
                    </p>
                @else
                    <p class="text-2xl font-bold text-gray-900">Por<br>confirmar</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Cuenta regresiva --}}
    <div class="card p-5 fade-up delay-3">
        <p class="text-xs font-semibold accent uppercase tracking-widest mb-4">Tiempo restante</p>
        <div class="grid grid-cols-4 gap-3 text-center" id="countdown">
            @foreach(['days' => 'Días', 'hours' => 'Horas', 'mins' => 'Min', 'secs' => 'Seg'] as $key => $label)
                <div>
                    <div id="cd-{{ $key }}"
                         class="text-2xl font-bold text-gray-900 tabular-nums bg-gray-50 rounded-lg py-2.5 border border-gray-100">
                        --
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5 font-medium">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Lugar --}}
    @if($event->venue_name || $event->venue_address)
        <div class="card p-5 fade-up delay-3">
            <p class="text-xs font-semibold accent uppercase tracking-widest mb-3">Ubicación</p>
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-lg navy flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    @if($event->venue_name)
                        <p class="font-semibold text-gray-900">{{ $event->venue_name }}</p>
                    @endif
                    @if($event->venue_address)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $event->venue_address }}</p>
                    @endif
                </div>
                @if($event->venue_maps_url)
                    <a href="{{ $event->venue_maps_url }}" target="_blank"
                       class="text-xs font-semibold accent hover:underline flex-shrink-0">
                        Ver mapa →
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- Dress code --}}
    @if($event->dress_code)
        <div class="card p-5 fade-up delay-5 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg navy flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold accent uppercase tracking-wider">Vestimenta</p>
                <p class="font-semibold text-gray-900 text-sm">{{ $event->dress_code }}</p>
            </div>
        </div>
        @if($event->dress_code_colors)
            <div class="fade-up delay-5 card p-4" style="text-align:center;">
                <p class="text-xs font-semibold accent uppercase tracking-wider mb-2">Por favor evita estos colores</p>
                <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                    @foreach($event->dress_code_colors as $color)
                        <div title="{{ $color['label'] ?? '' }}"
                             style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.1);position:relative;">
                            <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #1e40af;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#1e40af 50%,transparent calc(50% + 0.5px));display:block;"></span>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs font-semibold accent mt-2">Reservados para la festejada</p>
                @if($event->dress_code_colors_note)
                    <p class="text-xs text-gray-400 mt-1 italic">{{ $event->dress_code_colors_note }}</p>
                @endif
            </div>
        @endif
    @endif

    {{-- Notas --}}
    @if($event->notes)
        <div class="card p-5 fade-up delay-5">
            <p class="text-xs font-semibold accent uppercase tracking-widest mb-2">Notas importantes</p>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $event->notes }}</p>
        </div>
    @endif

    {{-- Itinerario --}}
    @if($event->itinerary)
        <div class="card p-5 fade-up delay-5">
            <p class="text-xs font-semibold accent uppercase tracking-widest mb-4">Agenda del evento</p>
            <div class="space-y-3">
                @foreach($event->itinerary as $item)
                    <div class="timeline-item">
                        <p class="font-semibold text-gray-900 text-sm leading-snug">{{ $item['title'] }}</p>
                        @if(!empty($item['time']))
                            <p class="text-xs accent mt-0.5">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</p>
                        @endif
                        @if(!empty($item['description']))
                            <p class="text-xs text-gray-500 mt-0.5">{{ $item['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-5">
            <p class="text-xs font-semibold accent uppercase tracking-widest mb-3 px-1">Galería</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach($event->photos->skip(1)->take(6) as $photo)
                    <div class="aspect-square overflow-hidden rounded-xl">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── GIFTS ── --}}
    @if($event->gifts)
    <div class="card p-5 fade-up delay-5" style="text-align:center;margin-bottom:1rem;">
        <p class="text-xs font-semibold accent uppercase tracking-wider mb-1">Mesa de regalos</p>
        <p class="font-semibold text-gray-800 mb-1">{{ $event->gifts_title ?? 'Tu presencia es el mejor regalo' }}</p>
        @if($event->gifts_subtitle)
            <p class="text-xs text-gray-400 mb-3">{{ $event->gifts_subtitle }}</p>
        @endif
        @php $giftCols = count($event->gifts) === 1 ? 'minmax(0,300px)' : 'repeat(auto-fit,minmax(180px,1fr))'; @endphp
        <div style="display:grid;grid-template-columns:{{ $giftCols }};gap:10px;max-width:780px;margin:14px auto 0;">
            @foreach($event->gifts as $gift)
                @if(!empty($gift['url']))
                    <a href="{{ $gift['url'] }}" target="_blank" rel="noopener"
                       style="display:block;border:1px solid #dbeafe;border-radius:8px;padding:14px;text-decoration:none;background:#f8fafc;transition:background 0.2s;">
                @else
                    <div style="border:1px solid #dbeafe;border-radius:8px;padding:14px;background:#f8fafc;">
                @endif
                    <p class="font-semibold text-gray-800 text-sm">{{ $gift['title'] }}</p>
                    @if(!empty($gift['description']))
                        <p class="text-xs text-gray-400 mt-1">{{ $gift['description'] }}</p>
                    @endif
                    @if(!empty($gift['url']))
                        <p class="text-xs font-semibold accent mt-2">Ver →</p>
                    @endif
                @if(!empty($gift['url']))</a>@else</div>@endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { border-color:#1d4ed8 !important; color:#1d4ed8 !important; font-weight:600; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; }
    </style>
    <div class="card p-5 fade-up delay-6" style="text-align:center;margin-bottom:1rem;">
        <p class="text-xs font-semibold accent uppercase tracking-wider mb-1">Confirma tu asistencia</p>
        <p class="font-semibold text-gray-800 mb-4">¿Podrás asistir al evento?</p>
        <form id="rsvp-form" novalidate>
            <div style="margin-bottom:10px;">
                <input id="rsvp-name" type="text" placeholder="Nombre completo" autocomplete="name"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm outline-none" style="font-family:inherit;">
            </div>
            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                <button type="button" class="rsvp-opt" data-val="yes"
                        style="flex:1;padding:8px;border:1px solid #dbeafe;border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:#1e40af;font-family:inherit;transition:all 0.2s;">
                    ✓ Sí, confirmo
                </button>
                <button type="button" class="rsvp-opt" data-val="no"
                        style="flex:1;padding:8px;border:1px solid #dbeafe;border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:#6b7280;font-family:inherit;transition:all 0.2s;">
                    No podré
                </button>
            </div>
            <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Asistentes:</span>
                <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid #dbeafe;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#1e40af;">−</button>
                <span id="g-count" class="font-semibold text-gray-800" style="font-size:1rem;min-width:20px;text-align:center;">1</span>
                <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid #1d4ed8;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#1e40af;">+</button>
            </div>
            <button type="submit" id="rsvp-btn" disabled
                    class="w-full py-2 rounded-lg text-sm font-semibold text-white"
                    style="background:#1d4ed8;border:none;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;">
                Confirmar asistencia
            </button>
        </form>
        <div id="rsvp-thanks" style="display:none;padding:16px 0;">
            <p style="font-size:1.5rem;color:#1d4ed8;">✓</p>
            <h3 id="thanks-title" class="font-semibold text-gray-800 mt-1" style="font-size:1.1rem;"></h3>
            <p id="thanks-body" class="text-sm text-gray-500 mt-2"></p>
        </div>
    </div>
    @endif

    {{-- Cierre --}}
    <div class="fade-up delay-7 text-center py-6">
        <div class="accent-line mb-4" style="max-width:60px;margin-left:auto;margin-right:auto;"></div>
        <p class="text-xs font-semibold accent uppercase tracking-widest">{{ $event->name }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ ucfirst($event->event_date->translatedFormat('d \d\e F Y')) }}</p>
    </div>

</div>

<script>
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '09:00' }}');
    function update() {
        const diff = eventDate - Date.now();
        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p class="col-span-4 text-center font-semibold text-blue-600">El evento es hoy 🏢</p>';
            return;
        }
        document.getElementById('cd-days').textContent  = String(Math.floor(diff/86400000)).padStart(2,'0');
        document.getElementById('cd-hours').textContent = String(Math.floor(diff%86400000/3600000)).padStart(2,'0');
        document.getElementById('cd-mins').textContent  = String(Math.floor(diff%3600000/60000)).padStart(2,'0');
        document.getElementById('cd-secs').textContent  = String(Math.floor(diff%60000/1000)).padStart(2,'0');
    }
    update();
    setInterval(update, 1000);

    // ── RSVP ──
    (function () {
        const form = document.getElementById('rsvp-form');
        if (!form) return;
        let attending = null, guests = 1;
        const btn = document.getElementById('rsvp-btn'), thanks = document.getElementById('rsvp-thanks');
        const gField = document.getElementById('guests-field'), gMinus = document.getElementById('g-minus');
        const gPlus = document.getElementById('g-plus'), gCount = document.getElementById('g-count');
        const nameInput = document.getElementById('rsvp-name');
        document.querySelectorAll('.rsvp-opt').forEach(opt => {
            opt.addEventListener('click', () => {
                attending = opt.dataset.val;
                document.querySelectorAll('.rsvp-opt').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                gField.style.display = attending === 'yes' ? 'flex' : 'none';
                updateBtn();
            });
        });
        nameInput.addEventListener('input', updateBtn);
        function updateBtn() { const ok = nameInput.value.trim().length > 1 && attending !== null; btn.disabled = !ok; btn.style.opacity = ok ? '1' : '0.45'; }
        gMinus.addEventListener('click', () => { guests = Math.max(1,guests-1); gCount.textContent=guests; gMinus.disabled=guests<=1; gPlus.disabled=guests>=8; });
        gPlus.addEventListener('click',  () => { guests = Math.min(8,guests+1); gCount.textContent=guests; gMinus.disabled=guests<=1; gPlus.disabled=guests>=8; });
        form.addEventListener('submit', e => {
            e.preventDefault(); if (btn.disabled) return;
            const name = nameInput.value.trim();
            form.style.display = 'none'; thanks.style.display = 'block';
            document.getElementById('thanks-title').textContent = attending === 'yes' ? `¡Gracias, ${name}!` : `Hasta pronto, ${name}`;
            document.getElementById('thanks-body').textContent  = attending === 'yes'
                ? `Te esperamos junto a ${guests > 1 ? `tus ${guests-1} acompañante${guests-1>1?'s':''}` : 'nosotros'} el {{ $event->event_date->translatedFormat('d \d\e F') }}. ¡Nos vemos pronto!`
                : 'Lamentamos no poder contar contigo en esta ocasión. Gracias por avisarnos.';
        });
    })();
</script>

</body>
</html>
