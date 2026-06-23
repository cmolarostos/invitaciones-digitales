<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-body    { font-family: 'DM Sans', sans-serif; }

        .gradient-bg {
            background: linear-gradient(160deg, #fff1f8 0%, #fdf4ff 40%, #f0f4ff 100%);
        }

        .glass-card {
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.8);
        }

        .divider-line {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .divider-line::before,
        .divider-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e8a0c0, transparent);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-8px); }
        }
        .float { animation: float 4s ease-in-out infinite; }

    </style>
</head>
<body class="font-body gradient-bg text-stone-700 antialiased">

{{-- ── Decoración de fondo ─────────────────────────────────────────────────── --}}
<div class="fixed inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
    <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-pink-100 opacity-40 blur-3xl"></div>
    <div class="absolute top-1/3 -right-24 w-80 h-80 rounded-full bg-purple-100 opacity-30 blur-3xl"></div>
    <div class="absolute -bottom-20 left-1/3 w-72 h-72 rounded-full bg-rose-100 opacity-35 blur-3xl"></div>
</div>

<div class="relative max-w-lg mx-auto px-4 py-12 space-y-10">

    {{-- ── HERO ────────────────────────────────────────────────────────────── --}}
    <section class="text-center fade-up delay-1">

        {{-- Foto de portada --}}
        @if($cover = $event->coverPhoto())
            <div class="relative mx-auto w-52 h-52 mb-8 float">
                <img src="{{ $cover->url }}" alt="{{ $event->name }}"
                     class="w-full h-full object-cover rounded-full shadow-xl ring-4 ring-white">
                <div class="absolute inset-0 rounded-full ring-1 ring-pink-200"></div>
            </div>
        @endif

        {{-- Encabezado --}}
        <p class="text-xs uppercase tracking-[0.3em] text-pink-400 font-medium mb-3">
            ✦ Mis XV Años ✦
        </p>

        <h1 class="font-display text-6xl text-stone-800 leading-none mb-2">
            {{ $event->name }}
        </h1>

        <p class="font-display italic text-xl text-pink-400 mt-2">
            una noche para recordar
        </p>
    </section>

    {{-- ── CUENTA REGRESIVA ────────────────────────────────────────────────── --}}
    <section class="fade-up delay-3">
        <div class="glass-card rounded-3xl p-6 text-center shadow-sm">
            <p class="text-xs uppercase tracking-widest text-pink-400 mb-4">Faltan</p>
            <div class="grid grid-cols-4 gap-3" id="countdown">
                @foreach(['days' => 'Días', 'hours' => 'Horas', 'mins' => 'Min', 'secs' => 'Seg'] as $key => $label)
                    <div class="flex flex-col items-center">
                        <span id="cd-{{ $key }}"
                              class="font-display text-4xl font-semibold text-stone-800 tabular-nums">
                            --
                        </span>
                        <span class="text-xs text-stone-400 mt-1">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── FECHA Y LUGAR ───────────────────────────────────────────────────── --}}
    <section class="fade-up delay-5 space-y-4">

        {{-- Fecha --}}
        <div class="glass-card rounded-3xl p-6 text-center shadow-sm">
            <div class="divider-line mb-4">
                <span class="text-xs uppercase tracking-widest text-pink-400">La fecha</span>
            </div>

            @php
                $date = $event->event_date;
            @endphp

            <div class="flex items-center justify-center gap-6">
                <div class="text-center">
                    <p class="font-display text-6xl font-light text-stone-800 leading-none">
                        {{ $date->format('d') }}
                    </p>
                </div>
                <div class="text-left">
                    <p class="font-display text-2xl text-pink-500 capitalize">
                        {{ $date->translatedFormat('F') }}
                    </p>
                    <p class="font-display text-xl text-stone-500">
                        {{ $date->format('Y') }}
                    </p>
                    @if($event->event_time)
                        <p class="text-sm text-stone-400 mt-1">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                    @endif
                </div>
            </div>

            <p class="font-display italic text-stone-400 mt-3 capitalize">
                {{ $date->translatedFormat('l') }}
            </p>
        </div>

        {{-- Lugar --}}
        @if($event->venue_name || $event->venue_address)
            <div class="glass-card rounded-3xl p-6 text-center shadow-sm">
                <div class="divider-line mb-4">
                    <span class="text-xs uppercase tracking-widest text-pink-400">El lugar</span>
                </div>

                @if($event->venue_name)
                    <p class="font-display text-2xl text-stone-800">{{ $event->venue_name }}</p>
                @endif
                @if($event->venue_address)
                    <p class="text-sm text-stone-500 mt-1">{{ $event->venue_address }}</p>
                @endif
                @if($event->venue_maps_url)
                    <a href="{{ $event->venue_maps_url }}" target="_blank"
                       class="inline-flex items-center gap-1.5 mt-4 text-sm text-pink-500 hover:text-pink-600 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                        </svg>
                        Ver en el mapa
                    </a>
                @endif
            </div>
        @endif

    </section>

    {{-- ── VESTIMENTA Y NOTAS ──────────────────────────────────────────────── --}}
    @if($event->dress_code || $event->notes)
        <section class="fade-up delay-7 space-y-4">
            @if($event->dress_code)
                <div class="glass-card rounded-3xl p-5 text-center shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-pink-400 mb-2">Vestimenta</p>
                    <p class="font-display text-2xl text-stone-800">{{ $event->dress_code }}</p>
                    @if($event->dress_code_colors)
                        <div style="margin-top:16px;">
                            <p class="text-xs uppercase tracking-widest text-stone-400 mb-2">Por favor evita estos colores</p>
                            <div style="display:flex;justify-content:center;gap:10px;flex-wrap:wrap;">
                                @foreach($event->dress_code_colors as $color)
                                    <div title="{{ $color['label'] ?? '' }}"
                                         style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.1);position:relative;">
                                        <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #e88;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#e88 50%,transparent calc(50% + 0.5px));display:block;"></span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-pink-400 mt-2">Reservados para la festejada</p>
                            @if($event->dress_code_colors_note)
                                <p class="text-xs text-stone-400 mt-1 italic">{{ $event->dress_code_colors_note }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            @if($event->notes)
                <div class="glass-card rounded-3xl p-5 text-center shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-pink-400 mb-2">Nota especial</p>
                    <p class="text-sm text-stone-600 leading-relaxed">{{ $event->notes }}</p>
                </div>
            @endif
        </section>
    @endif

    {{-- ── ITINERARIO ──────────────────────────────────────────────────────── --}}
    @if($event->itinerary)
        <section class="fade-up delay-7 space-y-4">
            <div class="divider-line mb-5">
                <span class="text-xs uppercase tracking-widest text-pink-400">Itinerario</span>
            </div>
            <div class="glass-card rounded-3xl p-6 shadow-sm divide-y divide-pink-100">
                @foreach($event->itinerary as $item)
                    <div class="flex gap-4 {{ $loop->first ? '' : 'pt-4' }} {{ $loop->last ? '' : 'pb-4' }}">
                        @if(!empty($item['time']))
                            <span class="font-display text-pink-400 text-sm tabular-nums shrink-0 pt-0.5">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                        @endif
                        <div>
                            <p class="font-display text-lg text-stone-800">{{ $item['title'] }}</p>
                            @if(!empty($item['description']))
                                <p class="text-sm text-stone-500 mt-0.5">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ── GALERÍA ─────────────────────────────────────────────────────────── --}}
    @if($event->photos->count() > 1)
        <section class="fade-up delay-7">
            <div class="divider-line mb-5">
                <span class="text-xs uppercase tracking-widest text-pink-400">Galería</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach($event->photos->reject(fn($p) => $cover && $p->id === $cover->id)->take(9) as $photo)
                    <div class="aspect-square overflow-hidden rounded-2xl">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ── GIFTS ── --}}
    @if($event->gifts)
    <section class="fade-up delay-5 space-y-4">
        <div class="glass-card rounded-3xl p-5 text-center shadow-sm">
            <p class="text-xs uppercase tracking-widest text-pink-400 mb-1">Mesa de regalos</p>
            <p class="font-display text-2xl text-stone-800 mb-1">{{ $event->gifts_title ?? 'Tu presencia es el mejor regalo' }}</p>
            @if($event->gifts_subtitle)
                <p class="text-xs text-stone-400 mb-3">{{ $event->gifts_subtitle }}</p>
            @endif
            @php $giftCols = count($event->gifts) === 1 ? 'minmax(0,300px)' : 'repeat(auto-fit,minmax(170px,1fr))'; @endphp
            <div style="display:grid;grid-template-columns:{{ $giftCols }};gap:10px;max-width:700px;margin:14px auto 0;">
                @foreach($event->gifts as $gift)
                    @if(!empty($gift['url']))
                        <a href="{{ $gift['url'] }}" target="_blank" rel="noopener"
                           style="display:block;border:1px solid #fce7f3;border-radius:16px;padding:14px;text-decoration:none;background:white;transition:background 0.2s;">
                    @else
                        <div style="border:1px solid #fce7f3;border-radius:16px;padding:14px;background:white;">
                    @endif
                        <p class="font-display text-lg text-stone-700">{{ $gift['title'] }}</p>
                        @if(!empty($gift['description']))
                            <p class="text-xs text-stone-400 mt-1">{{ $gift['description'] }}</p>
                        @endif
                        @if(!empty($gift['url']))
                            <p class="text-xs text-pink-400 mt-2">Ver →</p>
                        @endif
                    @if(!empty($gift['url']))</a>@else</div>@endif
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { border-color:#f472b6 !important; color:#ec4899 !important; background:rgba(244,114,182,0.08) !important; font-weight:600; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; }
    </style>
    <section class="fade-up delay-7 space-y-4">
        <div class="glass-card rounded-3xl p-5 text-center shadow-sm">
            <p class="text-xs uppercase tracking-widest text-pink-400 mb-1">Confirma tu asistencia</p>
            <p class="font-display text-2xl text-stone-800 mb-4">¿Nos acompañas?</p>
            <form id="rsvp-form" novalidate>
                <div style="margin-bottom:10px;">
                    <input id="rsvp-name" type="text" placeholder="Tu nombre completo" autocomplete="name"
                           class="w-full border border-pink-100 rounded-2xl px-3 py-2 text-sm bg-white/60 outline-none font-inherit">
                </div>
                <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                    <button type="button" class="rsvp-opt" data-val="yes"
                            style="flex:1;padding:8px;border:1px solid #fce7f3;border-radius:16px;font-size:0.8rem;background:transparent;cursor:pointer;color:#be185d;font-family:inherit;transition:all 0.2s;">
                        Sí, ahí estaré ✦
                    </button>
                    <button type="button" class="rsvp-opt" data-val="no"
                            style="flex:1;padding:8px;border:1px solid #fce7f3;border-radius:16px;font-size:0.8rem;background:transparent;cursor:pointer;color:#78716c;font-family:inherit;transition:all 0.2s;">
                        No podré
                    </button>
                </div>
                <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                    <span class="text-xs text-stone-500">Invitados:</span>
                    <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid #fce7f3;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#be185d;">−</button>
                    <span id="g-count" class="text-stone-700" style="font-size:1rem;min-width:20px;text-align:center;">1</span>
                    <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid #f472b6;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#be185d;">+</button>
                </div>
                <button type="submit" id="rsvp-btn" disabled
                        class="w-full py-2 rounded-2xl text-sm font-display"
                        style="background:#f472b6;color:white;border:none;cursor:pointer;opacity:0.45;transition:opacity 0.2s;">
                    Confirmar asistencia
                </button>
            </form>
            <div id="rsvp-thanks" style="display:none;padding:16px 0;">
                <p class="text-3xl">💕</p>
                <h3 id="thanks-title" class="font-display text-xl text-stone-700 mt-2"></h3>
                <p id="thanks-body" class="text-sm text-stone-500 mt-2"></p>
            </div>
            @if($event->rsvp_whatsapp)
            <div style="margin-top:14px;padding-top:14px;border-top:1px solid #fce7f3;">
                <p class="text-xs text-stone-500" style="margin-bottom:10px;">Confirma tu asistencia al siguiente WhatsApp</p>
                <a href="https://wa.me/{{ $event->rsvp_whatsapp }}?text={{ rawurlencode('¡Hola! Quiero confirmar mi asistencia a '.$event->name."\nNombre completo: ") }}"
                   target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:#25D366;color:#fff;border-radius:16px;font-size:0.85rem;text-decoration:none;font-family:inherit;">
                    <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor;flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.149-.15.347-.39.52-.585.173-.198.232-.347.347-.578.116-.232.058-.43-.04-.578-.099-.149-.669-1.612-.916-2.207-.242-.58-.487-.501-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.05 3.131 4.966 4.266 2.917 1.135 2.917.756 3.444.71.528-.05 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.116 1.524 5.84L0 24l6.304-1.484A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.78 9.78 0 01-5.07-1.407l-.364-.218-3.74.88.89-3.642-.238-.374A9.76 9.76 0 012.182 12C2.182 6.586 6.586 2.182 12 2.182S21.818 6.586 21.818 12 17.414 21.818 12 21.818z"/></svg>
                    Confirmar por WhatsApp
                </a>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ── CIERRE ──────────────────────────────────────────────────────────── --}}
    <footer class="text-center py-6 fade-up delay-7">
        <p class="font-display italic text-2xl text-pink-400">Con amor,</p>
        <p class="font-display text-3xl text-stone-700 mt-1">{{ $event->name }}</p>
        <p class="text-xs text-stone-300 mt-6 tracking-widest uppercase">✦ ✦ ✦</p>
    </footer>

</div>

<script>
    (function () {
        const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '20:00' }}');

        function update() {
            const diff = eventDate - Date.now();

            if (diff <= 0) {
                document.getElementById('countdown').innerHTML =
                    '<p class="col-span-4 font-display italic text-2xl text-pink-400">¡Hoy es el gran día! 🎉</p>';
                return;
            }

            const days  = Math.floor(diff / 86400000);
            const hours = Math.floor((diff % 86400000) / 3600000);
            const mins  = Math.floor((diff % 3600000)  / 60000);
            const secs  = Math.floor((diff % 60000)    / 1000);

            document.getElementById('cd-days').textContent  = String(days).padStart(2, '0');
            document.getElementById('cd-hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('cd-mins').textContent  = String(mins).padStart(2, '0');
            document.getElementById('cd-secs').textContent  = String(secs).padStart(2, '0');
        }

        update();
        setInterval(update, 1000);
    })();

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
