<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background: #fafafa; }

        .gradient-hero {
            background: linear-gradient(135deg, #6c63ff 0%, #8b5cf6 50%, #a78bfa 100%);
        }

        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(108,99,255,0.08);
        }

        .chip {
            display: inline-block;
            background: #f0eeff;
            color: #6c63ff;
            border-radius: 999px;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .confetti-dot {
            position: fixed;
            border-radius: 2px;
            animation: fall linear infinite;
            pointer-events: none;
        }

        @keyframes fall {
            0%   { transform: translateY(-20px) rotate(0deg);   opacity: 1; }
            100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
        }

    </style>
</head>
<body>

{{-- Confetti --}}
<div aria-hidden="true" id="confetti"></div>

<div class="max-w-lg mx-auto px-4 pb-16">

    {{-- Hero --}}
    <div class="gradient-hero rounded-b-[40px] px-6 pt-14 pb-16 text-center text-white mb-6 fade-up delay-1">

        @if($cover = $event->coverPhoto())
            <div class="w-28 h-28 mx-auto mb-6 rounded-full overflow-hidden ring-4 ring-white/30 shadow-xl">
                <img src="{{ $cover->url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
            </div>
        @endif

        <span class="chip bg-white/20 text-white mb-4 inline-block">🎂 Cumpleaños</span>

        <h1 class="text-4xl font-extrabold leading-tight mt-3">
            ¡Cumpleaños de<br>{{ $event->name }}!
        </h1>
        <p class="mt-3 text-white/70 text-sm font-medium">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
            @if($event->event_time) · {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} @endif
        </p>
    </div>

    {{-- Cuenta regresiva --}}
    <div class="card p-5 mb-4 fade-up delay-3">
        <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest text-center mb-4">
            Faltan
        </p>
        <div class="grid grid-cols-4 gap-3 text-center" id="countdown">
            @foreach(['days' => 'Días', 'hours' => 'Horas', 'mins' => 'Min', 'secs' => 'Seg'] as $key => $label)
                <div>
                    <div id="cd-{{ $key }}"
                         class="text-3xl font-extrabold text-gray-900 tabular-nums
                                bg-purple-50 rounded-2xl py-3">--</div>
                    <p class="text-xs text-gray-400 mt-1.5 font-medium">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Info cards --}}
    <div class="grid grid-cols-2 gap-4 mb-4 fade-up delay-5">

        {{-- Fecha --}}
        <div class="card p-4 text-center">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">Fecha</p>
            <p class="text-4xl font-extrabold text-gray-900">{{ $event->event_date->format('d') }}</p>
            <p class="text-sm font-semibold text-purple-500 capitalize">
                {{ $event->event_date->translatedFormat('F') }}
            </p>
            <p class="text-xs text-gray-400">{{ $event->event_date->format('Y') }}</p>
        </div>

        {{-- Hora --}}
        <div class="card p-4 text-center">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">Hora</p>
            @if($event->event_time)
                <p class="text-4xl font-extrabold text-gray-900">
                    {{ \Carbon\Carbon::parse($event->event_time)->format('g') }}
                </p>
                <p class="text-sm font-semibold text-purple-500">
                    {{ \Carbon\Carbon::parse($event->event_time)->format('A') }}
                </p>
            @else
                <p class="text-3xl font-extrabold text-gray-900">--</p>
                <p class="text-xs text-gray-400">Por confirmar</p>
            @endif
        </div>
    </div>

    {{-- Lugar --}}
    @if($event->venue_name || $event->venue_address)
        <div class="card p-5 mb-4 fade-up delay-5">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-3">El lugar</p>
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <div>
                    @if($event->venue_name)
                        <p class="font-bold text-gray-900">{{ $event->venue_name }}</p>
                    @endif
                    @if($event->venue_address)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $event->venue_address }}</p>
                    @endif
                    @if($event->venue_maps_url)
                        <a href="{{ $event->venue_maps_url }}" target="_blank"
                           class="inline-block mt-2 text-xs font-semibold text-purple-600 hover:underline">
                            Ver en el mapa →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Dress code / Notas --}}
    @if($event->dress_code || $event->notes)
        <div class="grid gap-4 mb-4 fade-up delay-5 {{ $event->dress_code && $event->notes ? 'grid-cols-1' : '' }}">
            @if($event->dress_code)
                <div class="card p-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">👔</span>
                        <div>
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest">Vestimenta</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $event->dress_code }}</p>
                        </div>
                    </div>
                    @if($event->dress_code_colors)
                        <div style="margin-top:14px; text-align:center;">
                            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">Por favor evita estos colores</p>
                            <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                                @foreach($event->dress_code_colors as $color)
                                    <div title="{{ $color['label'] ?? '' }}"
                                         style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.1);position:relative;">
                                        <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #9333ea;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#9333ea 50%,transparent calc(50% + 0.5px));display:block;"></span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs font-semibold text-purple-400 mt-2">Reservados para la festejada</p>
                            @if($event->dress_code_colors_note)
                                <p class="text-xs text-gray-400 mt-1 italic">{{ $event->dress_code_colors_note }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            @if($event->notes)
                <div class="card p-4">
                    <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-2">📝 Nota especial</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $event->notes }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Itinerario --}}
    @if($event->itinerary)
        <div class="card p-5 mb-4 fade-up delay-5">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-3">Itinerario</p>
            <div class="divide-y divide-purple-50">
                @foreach($event->itinerary as $item)
                    <div class="flex gap-3 {{ $loop->first ? '' : 'pt-3' }} {{ $loop->last ? '' : 'pb-3' }}">
                        @if(!empty($item['time']))
                            <span class="text-xs font-semibold text-purple-400 tabular-nums shrink-0 pt-0.5">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $item['title'] }}</p>
                            @if(!empty($item['description']))
                                <p class="text-xs text-gray-500 mt-0.5">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-5">
            <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-3">Galería</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach($event->photos->skip(1)->take(9) as $photo)
                    <div class="aspect-square overflow-hidden rounded-2xl">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { border-color:#a855f7 !important; color:#9333ea !important; font-weight:600; background:rgba(168,85,247,0.08) !important; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; }
    </style>
    <div class="card p-4 fade-up delay-6 mb-4" style="text-align:center;">
        <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest mb-1">🎉 Confirma tu asistencia</p>
        <p class="font-bold text-gray-900 mb-4">¿Nos acompañas a la fiesta?</p>
        <form id="rsvp-form" novalidate>
            <div style="margin-bottom:10px;">
                <input id="rsvp-name" type="text" placeholder="Tu nombre" autocomplete="name"
                       class="w-full border border-purple-100 rounded-2xl px-3 py-2 text-sm outline-none" style="font-family:inherit;">
            </div>
            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                <button type="button" class="rsvp-opt" data-val="yes"
                        style="flex:1;padding:8px;border:1px solid #e9d5ff;border-radius:16px;font-size:0.8rem;background:transparent;cursor:pointer;color:#7c3aed;font-family:inherit;transition:all 0.2s;">
                    🎊 Sí, ahí estaré
                </button>
                <button type="button" class="rsvp-opt" data-val="no"
                        style="flex:1;padding:8px;border:1px solid #e9d5ff;border-radius:16px;font-size:0.8rem;background:transparent;cursor:pointer;color:#9ca3af;font-family:inherit;transition:all 0.2s;">
                    No podré
                </button>
            </div>
            <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                <span class="text-xs font-semibold text-purple-400">Invitados:</span>
                <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid #e9d5ff;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#7c3aed;">−</button>
                <span id="g-count" class="font-bold text-gray-800" style="font-size:1rem;min-width:20px;text-align:center;">1</span>
                <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid #a855f7;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#7c3aed;">+</button>
            </div>
            <button type="submit" id="rsvp-btn" disabled
                    class="w-full py-2 rounded-2xl text-sm font-bold text-white"
                    style="background:linear-gradient(135deg,#a855f7,#6c63ff);border:none;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;">
                ¡Confirmar!
            </button>
        </form>
        <div id="rsvp-thanks" style="display:none;padding:16px 0;">
            <p style="font-size:2rem;">🎉</p>
            <h3 id="thanks-title" class="font-bold text-gray-800 mt-1" style="font-size:1.1rem;"></h3>
            <p id="thanks-body" class="text-sm text-gray-500 mt-2"></p>
        </div>
    </div>
    @endif

    {{-- Cierre --}}
    <div class="fade-up delay-7 text-center py-6 mb-4">
        <p class="text-2xl">🎂 ✨ 🎊</p>
        <p class="font-bold text-gray-700 mt-2">{{ $event->name }}</p>
        <p class="text-xs text-gray-400 mt-1 tracking-widest uppercase">{{ ucfirst($event->event_date->translatedFormat('d \d\e F Y')) }}</p>
    </div>

</div>

<script>
    // Confetti
    const colors = ['#6c63ff','#a78bfa','#f472b6','#fbbf24','#34d399'];
    for (let i = 0; i < 18; i++) {
        const el = document.createElement('div');
        el.className = 'confetti-dot';
        const size = Math.random() * 7 + 5;
        el.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random()*100}vw;
            background:${colors[Math.floor(Math.random()*colors.length)]};
            opacity:${Math.random()*0.5+0.3};
            animation-duration:${Math.random()*6+5}s;
            animation-delay:${Math.random()*4}s;
            border-radius:${Math.random() > 0.5 ? '50%' : '2px'};
        `;
        document.getElementById('confetti').appendChild(el);
    }

    // Countdown
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '20:00' }}');
    function update() {
        const diff = eventDate - Date.now();
        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p class="col-span-4 text-center text-xl font-bold text-purple-600">🎉 ¡Hoy es el gran día!</p>';
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
