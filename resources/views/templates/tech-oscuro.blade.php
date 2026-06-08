<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #0d1117;
            font-family: 'Share Tech Mono', monospace;
            color: #67e8f9;
        }

        .font-display { font-family: 'Rajdhani', sans-serif; }

        .card {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(34, 211, 238, 0.15);
            border-radius: 8px;
            backdrop-filter: blur(8px);
        }

        .accent-line {
            height: 2px;
            width: 80px;
            background: linear-gradient(90deg, #22d3ee, transparent);
            margin: 0 auto;
        }

        .section-title {
            font-size: 0.65rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #22d3ee;
            opacity: 0.7;
            margin-bottom: 0.5rem;
        }

        .grid-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        /* Countdown */
        .cd-num {
            font-family: 'Share Tech Mono', monospace;
            font-size: 2.2rem;
            color: #fff;
            line-height: 1;
        }
        .cd-label {
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            color: #22d3ee;
            text-transform: uppercase;
            margin-top: 4px;
            opacity: 0.7;
        }

        /* Scanline overlay */
        .scanlines {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.05) 2px,
                rgba(0, 0, 0, 0.05) 4px
            );
        }

        /* Glow border on cards */
        .card-glow {
            box-shadow: 0 0 0 1px rgba(34, 211, 238, 0.1),
                        0 4px 24px rgba(34, 211, 238, 0.05);
        }

        /* Tag chip */
        .chip {
            display: inline-block;
            background: rgba(34, 211, 238, 0.1);
            border: 1px solid rgba(34, 211, 238, 0.3);
            color: #22d3ee;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            padding: 3px 12px;
            border-radius: 999px;
            text-transform: uppercase;
        }

        /* Gallery hover */
        .gallery-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid rgba(34, 211, 238, 0.1);
            transition: transform 0.4s ease, border-color 0.3s ease;
        }
        .gallery-img:hover {
            transform: scale(1.04);
            border-color: rgba(34, 211, 238, 0.5);
        }

        /* Cursor blink */
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        .cursor { animation: blink 1s step-end infinite; }

        /* Noise background blobs */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body>

{{-- Decoración de fondo --}}
<div class="scanlines" aria-hidden="true"></div>
<div class="blob" style="width:300px;height:300px;top:-80px;left:-80px;background:#0e7490;opacity:0.12;"></div>
<div class="blob" style="width:250px;height:250px;bottom:-60px;right:-60px;background:#164e63;opacity:0.15;"></div>

<div class="relative z-10 max-w-lg mx-auto px-4 py-12 space-y-6">

    {{-- Header --}}
    <header class="fade-up delay-1 text-center space-y-4">
        <span class="chip">{{ $event->template->eventType->name ?? 'Evento' }}</span>

        <div>
            <p class="section-title mt-4">Estás invitado a</p>
            <h1 class="font-display text-5xl font-bold text-white leading-tight mt-1">
                {{ $event->name }}<span class="cursor text-cyan-400">_</span>
            </h1>
        </div>

        <div class="accent-line"></div>

        <p class="text-xs opacity-50">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
            @if($event->event_time) · {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }} @endif
        </p>
    </header>

    {{-- Foto de portada --}}
    @if($cover = $event->coverPhoto())
        <div class="fade-up delay-2 overflow-hidden rounded-lg card-glow"
             style="border: 1px solid rgba(34,211,238,0.15);">
            <img src="{{ $cover->url }}" alt="{{ $event->name }}"
                 class="w-full max-h-72 object-cover">
            <div style="height:2px;background:linear-gradient(90deg,transparent,#22d3ee,transparent);"></div>
        </div>
    @endif

    {{-- Cuenta regresiva --}}
    <div class="fade-up delay-3 card card-glow p-5 text-center">
        <p class="section-title">Sistema de cuenta regresiva</p>
        <div class="flex justify-center gap-6 mt-3" id="countdown">
            <div><p class="cd-num" id="cd-days">--</p><p class="cd-label">Días</p></div>
            <div><p class="cd-num" id="cd-hours">--</p><p class="cd-label">Horas</p></div>
            <div><p class="cd-num" id="cd-mins">--</p><p class="cd-label">Min</p></div>
            <div><p class="cd-num" id="cd-secs">--</p><p class="cd-label">Seg</p></div>
        </div>
    </div>

    {{-- Detalles --}}
    <div class="fade-up delay-4 grid-info">

        {{-- Fecha --}}
        <div class="card card-glow p-4">
            <p class="section-title">Fecha</p>
            <p class="font-display text-4xl font-bold text-white leading-none">
                {{ $event->event_date->format('d') }}
            </p>
            <p class="text-cyan-400 text-sm mt-1 capitalize">
                {{ $event->event_date->translatedFormat('F') }}
            </p>
            <p class="text-xs opacity-50">{{ $event->event_date->format('Y') }}</p>
        </div>

        {{-- Hora --}}
        <div class="card card-glow p-4">
            <p class="section-title">Horario</p>
            @if($event->event_time)
                <p class="font-display text-4xl font-bold text-white leading-none">
                    {{ \Carbon\Carbon::parse($event->event_time)->format('g:i') }}
                </p>
                <p class="text-cyan-400 text-sm mt-1">
                    {{ \Carbon\Carbon::parse($event->event_time)->format('A') }}
                </p>
            @else
                <p class="font-display text-2xl font-bold text-white">Por<br>confirmar</p>
            @endif
        </div>

        {{-- Lugar --}}
        @if($event->venue_name || $event->venue_address)
            <div class="card card-glow p-4" style="grid-column: span 2;">
                <p class="section-title">Ubicación</p>
                @if($event->venue_name)
                    <p class="font-display text-xl font-semibold text-white">{{ $event->venue_name }}</p>
                @endif
                @if($event->venue_address)
                    <p class="text-xs opacity-60 mt-1">{{ $event->venue_address }}</p>
                @endif
                @if($event->venue_maps_url)
                    <a href="{{ $event->venue_maps_url }}" target="_blank"
                       class="inline-block mt-3 text-xs text-cyan-400 hover:text-white transition-colors">
                        &gt; Ver en el mapa_
                    </a>
                @endif
            </div>
        @endif

    </div>

    {{-- Dress code --}}
    @if($event->dress_code)
        <div class="fade-up delay-5 card card-glow p-4 flex items-center gap-4">
            <div style="width:36px;height:36px;background:rgba(34,211,238,0.1);border:1px solid rgba(34,211,238,0.25);
                        border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22d3ee" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                </svg>
            </div>
            <div>
                <p class="section-title" style="margin-bottom:2px;">Código de vestimenta</p>
                <p class="font-display text-lg font-semibold text-white">{{ $event->dress_code }}</p>
            </div>
        </div>
        @if($event->dress_code_colors)
            <div class="fade-up delay-5 card card-glow p-4" style="text-align:center;">
                <p class="section-title mb-2">Por favor evita estos colores</p>
                <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                    @foreach($event->dress_code_colors as $color)
                        <div title="{{ $color['label'] ?? '' }}"
                             style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(34,211,238,.2);position:relative;">
                            <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #22d3ee;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#22d3ee 50%,transparent calc(50% + 0.5px));display:block;"></span>
                        </div>
                    @endforeach
                </div>
                <p class="section-title mt-2">Reservados para la festejada</p>
                @if($event->dress_code_colors_note)
                    <p style="font-size:0.75rem; color:rgba(255,255,255,.45); margin-top:4px; font-style:italic;">{{ $event->dress_code_colors_note }}</p>
                @endif
            </div>
        @endif
    @endif

    {{-- Notas --}}
    @if($event->notes)
        <div class="fade-up delay-5 card card-glow p-4">
            <p class="section-title">Mensaje</p>
            <p class="text-sm leading-relaxed opacity-80">"{{ $event->notes }}"</p>
        </div>
    @endif

    {{-- Itinerario --}}
    @if($event->itinerary)
        <div class="fade-up delay-5 card card-glow p-4">
            <p class="section-title mb-3">Agenda del evento</p>
            <div class="space-y-3">
                @foreach($event->itinerary as $item)
                    <div class="flex gap-3 {{ !$loop->last ? 'pb-3 border-b border-cyan-900/40' : '' }}">
                        @if(!empty($item['time']))
                            <span class="text-xs text-cyan-400 tabular-nums shrink-0 pt-0.5">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                        @endif
                        <div>
                            <p class="font-display text-base font-semibold text-white leading-snug">{{ $item['title'] }}</p>
                            @if(!empty($item['description']))
                                <p class="text-xs opacity-50 mt-0.5">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-6">
            <p class="section-title px-1 mb-3">Galería</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                @foreach($event->photos->reject(fn($p) => $cover && $p->id === $cover->id)->take(9) as $photo)
                    <img src="{{ $photo->url }}" alt="" class="gallery-img">
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── GIFTS ── --}}
    @if($event->gifts)
    <div class="fade-up delay-5 card card-glow p-4" style="text-align:center;margin-bottom:1.5rem;">
        <p class="section-title mb-1">[ MESA DE REGALOS ]</p>
        <p class="font-display text-lg font-semibold text-white mb-1">{{ $event->gifts_title ?? 'Tu presencia es el mejor regalo' }}</p>
        @if($event->gifts_subtitle)
            <p class="section-title mb-3" style="font-size:0.75rem;">{{ $event->gifts_subtitle }}</p>
        @endif
        @php $giftCols = count($event->gifts) === 1 ? 'minmax(0,300px)' : 'repeat(auto-fit,minmax(180px,1fr))'; @endphp
        <div style="display:grid;grid-template-columns:{{ $giftCols }};gap:10px;max-width:780px;margin:14px auto 0;">
            @foreach($event->gifts as $gift)
                @if(!empty($gift['url']))
                    <a href="{{ $gift['url'] }}" target="_blank" rel="noopener"
                       style="display:block;border:1px solid rgba(34,211,238,0.25);border-radius:6px;padding:14px;text-decoration:none;background:rgba(34,211,238,0.05);transition:background 0.2s;">
                @else
                    <div style="border:1px solid rgba(34,211,238,0.25);border-radius:6px;padding:14px;background:rgba(34,211,238,0.05);">
                @endif
                    <p class="font-display font-semibold text-white text-sm">{{ $gift['title'] }}</p>
                    @if(!empty($gift['description']))
                        <p class="section-title mt-1" style="font-size:0.7rem;">{{ $gift['description'] }}</p>
                    @endif
                    @if(!empty($gift['url']))
                        <p style="font-size:0.75rem;color:#22d3ee;margin-top:8px;letter-spacing:0.1em;">VER →</p>
                    @endif
                @if(!empty($gift['url']))</a>@else</div>@endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { border-color:#22d3ee !important; color:#22d3ee !important; font-weight:600; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; }
    </style>
    <div class="fade-up delay-6 card card-glow p-5" style="text-align:center;margin-bottom:1.5rem;">
        <p class="section-title mb-1">[ CONFIRMA TU ASISTENCIA ]</p>
        <p class="font-display text-lg font-semibold text-white mb-4">¿Nos acompañarás?</p>
        <form id="rsvp-form" novalidate>
            <div style="margin-bottom:10px;">
                <input id="rsvp-name" type="text" placeholder="Tu nombre" autocomplete="name"
                       style="width:100%;background:rgba(255,255,255,0.05);border:1px solid rgba(34,211,238,0.3);border-radius:6px;padding:8px 12px;font-size:0.85rem;color:#e2e8f0;outline:none;font-family:inherit;">
            </div>
            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                <button type="button" class="rsvp-opt" data-val="yes"
                        style="flex:1;padding:8px;border:1px solid rgba(34,211,238,0.3);border-radius:6px;font-size:0.8rem;background:transparent;cursor:pointer;color:#94a3b8;font-family:inherit;transition:all 0.2s;">
                    &gt; Sí, ahí estaré
                </button>
                <button type="button" class="rsvp-opt" data-val="no"
                        style="flex:1;padding:8px;border:1px solid rgba(34,211,238,0.3);border-radius:6px;font-size:0.8rem;background:transparent;cursor:pointer;color:#94a3b8;font-family:inherit;transition:all 0.2s;">
                    &gt; No podré
                </button>
            </div>
            <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                <span class="section-title" style="font-size:0.75rem;">INVITADOS:</span>
                <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid rgba(34,211,238,0.3);border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#22d3ee;">−</button>
                <span id="g-count" style="font-size:1rem;color:#e2e8f0;min-width:20px;text-align:center;">1</span>
                <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid rgba(34,211,238,0.5);border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#22d3ee;">+</button>
            </div>
            <button type="submit" id="rsvp-btn" disabled
                    style="width:100%;padding:10px;background:#22d3ee;color:#0f172a;border:none;border-radius:6px;font-size:0.85rem;font-weight:700;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;letter-spacing:0.05em;">
                ENVIAR CONFIRMACIÓN
            </button>
        </form>
        <div id="rsvp-thanks" style="display:none;padding:16px 0;">
            <p style="font-size:1.5rem;color:#22d3ee;">✓</p>
            <h3 id="thanks-title" class="font-display text-lg font-semibold text-white mt-1"></h3>
            <p id="thanks-body" class="section-title mt-2" style="font-size:0.8rem;"></p>
        </div>
    </div>
    @endif

    {{-- Footer --}}
    <footer class="fade-up delay-7 text-center pt-4 pb-8">
        <div class="accent-line mb-4"></div>
        <p class="text-xs opacity-30 tracking-widest uppercase">
            &gt; fin de transmisión_
        </p>
    </footer>

</div>

<script>
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '20:00' }}');

    function update() {
        const diff = eventDate - Date.now();

        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p style="font-family:Rajdhani,sans-serif;font-size:1.3rem;font-weight:700;color:#22d3ee;letter-spacing:0.1em;">&gt; EVENTO EN CURSO_</p>';
            return;
        }

        document.getElementById('cd-days').textContent  = String(Math.floor(diff / 86400000)).padStart(2, '0');
        document.getElementById('cd-hours').textContent = String(Math.floor(diff % 86400000 / 3600000)).padStart(2, '0');
        document.getElementById('cd-mins').textContent  = String(Math.floor(diff % 3600000 / 60000)).padStart(2, '0');
        document.getElementById('cd-secs').textContent  = String(Math.floor(diff % 60000 / 1000)).padStart(2, '0');
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
