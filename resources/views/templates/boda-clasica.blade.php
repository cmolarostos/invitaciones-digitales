<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-body    { font-family: 'Jost', sans-serif; }

        body {
            background-color: #fff9f0;
            font-family: 'Jost', sans-serif;
        }

        .gold { color: #c9a96e; }

        .border-gold { border-color: #c9a96e; }

        .ornament-frame {
            position: relative;
        }
        .ornament-frame::before,
        .ornament-frame::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c9a96e, transparent);
        }
        .ornament-frame::before { top: 0; }
        .ornament-frame::after  { bottom: 0; }

    </style>
</head>
<body>

<div class="max-w-lg mx-auto px-6 py-14 text-center text-stone-700">

    {{-- Ornamento superior --}}
    <div class="fade-up delay-1 mb-2">
        <p class="font-display text-4xl gold opacity-60">❧</p>
    </div>

    {{-- Encabezado --}}
    <div class="fade-up delay-1 mb-8">
        <p class="font-body text-xs uppercase tracking-[0.35em] gold mb-5">
            Juntos celebramos
        </p>

        @if($cover = $event->coverPhoto())
            <div class="relative mx-auto w-48 h-48 mb-8">
                <img src="{{ $cover->url }}" alt="{{ $event->name }}"
                     class="w-full h-full object-cover rounded-full shadow-lg ring-1 ring-amber-200">
                <div class="absolute inset-0 rounded-full"
                     style="box-shadow: 0 0 0 6px rgba(201,169,110,0.15), 0 0 0 12px rgba(201,169,110,0.06)">
                </div>
            </div>
        @endif

        <h1 class="font-display text-5xl font-light text-stone-800 leading-tight">
            {{ $event->name }}
        </h1>

        {{-- Separador dorado --}}
        <div class="flex items-center justify-center gap-3 my-5">
            <div class="h-px w-16 bg-gradient-to-r from-transparent to-amber-300"></div>
            <span class="gold text-lg">♦</span>
            <div class="h-px w-16 bg-gradient-to-l from-transparent to-amber-300"></div>
        </div>

        <p class="font-display italic text-xl text-stone-500">
            nos unimos en matrimonio
        </p>
    </div>

    {{-- Fecha --}}
    <div class="fade-up delay-3 border border-amber-200 rounded-sm py-8 px-6 mb-6 ornament-frame">
        <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-4">La fecha</p>

        <div class="flex items-center justify-center gap-8">
            <div>
                <p class="font-display text-7xl font-light text-stone-800 leading-none">
                    {{ $event->event_date->format('d') }}
                </p>
            </div>
            <div class="text-left">
                <p class="font-display text-3xl gold capitalize">
                    {{ $event->event_date->translatedFormat('F') }}
                </p>
                <p class="font-display text-2xl text-stone-500">
                    {{ $event->event_date->format('Y') }}
                </p>
                @if($event->event_time)
                    <p class="font-body text-sm text-stone-400 mt-1">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                @endif
            </div>
        </div>

        <p class="font-display italic text-stone-400 mt-4 capitalize text-lg">
            {{ $event->event_date->translatedFormat('l') }}
        </p>
    </div>

    {{-- Cuenta regresiva --}}
    <div class="fade-up delay-3 bg-white/70 border border-amber-100 rounded-sm py-6 px-4 mb-6">
        <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-5">Faltan</p>
        <div class="grid grid-cols-4 gap-2" id="countdown">
            @foreach(['days' => 'Días', 'hours' => 'Horas', 'mins' => 'Min', 'secs' => 'Seg'] as $key => $label)
                <div>
                    <p id="cd-{{ $key }}"
                       class="font-display text-4xl text-stone-800 tabular-nums">--</p>
                    <p class="font-body text-xs text-stone-400 mt-1 uppercase tracking-wider">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Lugar --}}
    @if($event->venue_name || $event->venue_address)
        <div class="fade-up delay-5 mb-6">
            <div class="flex items-center justify-center gap-3 mb-5">
                <div class="h-px w-16 bg-gradient-to-r from-transparent to-amber-300"></div>
                <p class="font-body text-xs uppercase tracking-[0.3em] gold">El lugar</p>
                <div class="h-px w-16 bg-gradient-to-l from-transparent to-amber-300"></div>
            </div>

            @if($event->venue_name)
                <p class="font-display text-2xl text-stone-800">{{ $event->venue_name }}</p>
            @endif
            @if($event->venue_address)
                <p class="font-body text-sm text-stone-500 mt-1">{{ $event->venue_address }}</p>
            @endif
            @if($event->venue_maps_url)
                <a href="{{ $event->venue_maps_url }}" target="_blank"
                   class="inline-block mt-3 font-body text-xs uppercase tracking-wider gold hover:underline">
                    📍 Ver en el mapa
                </a>
            @endif
        </div>
    @endif

    {{-- Dress code / Notas --}}
    @if($event->dress_code || $event->notes)
        <div class="fade-up delay-5 space-y-3 mb-8">
            @if($event->dress_code)
                <div class="border border-amber-100 bg-white/50 py-3 px-4 rounded-sm">
                    <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-1">Vestimenta</p>
                    <p class="font-display text-xl text-stone-700">{{ $event->dress_code }}</p>
                    @if($event->dress_code_colors)
                        <div style="margin-top:14px; text-align:center;">
                            <p class="font-body text-xs uppercase tracking-[0.2em] text-stone-400 mb-2">Por favor evita estos colores</p>
                            <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                                @foreach($event->dress_code_colors as $color)
                                    <div title="{{ $color['label'] ?? '' }}"
                                         style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.08);position:relative;">
                                        <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #b8860b;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#b8860b 50%,transparent calc(50% + 0.5px));display:block;"></span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="font-body text-xs gold mt-2">Reservados para la festejada</p>
                            @if($event->dress_code_colors_note)
                                <p class="font-body text-xs text-stone-400 mt-1 italic">{{ $event->dress_code_colors_note }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            @if($event->notes)
                <div class="border border-amber-100 bg-white/50 py-3 px-4 rounded-sm">
                    <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-1">Nota especial</p>
                    <p class="font-body text-sm text-stone-600 leading-relaxed">{{ $event->notes }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Itinerario --}}
    @if($event->itinerary)
        <div class="fade-up delay-5 space-y-2 mb-6">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="h-px w-16 bg-gradient-to-r from-transparent to-amber-300"></div>
                <p class="font-body text-xs uppercase tracking-[0.3em] gold">Itinerario</p>
                <div class="h-px w-16 bg-gradient-to-l from-transparent to-amber-300"></div>
            </div>
            <div class="border border-amber-100 bg-white/50 rounded-sm divide-y divide-amber-100">
                @foreach($event->itinerary as $item)
                    <div class="flex gap-3 px-4 py-3">
                        @if(!empty($item['time']))
                            <span class="font-body text-xs gold tabular-nums shrink-0 pt-0.5">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                        @endif
                        <div class="text-left">
                            <p class="font-display text-base text-stone-800">{{ $item['title'] }}</p>
                            @if(!empty($item['description']))
                                <p class="font-body text-xs text-stone-500 mt-0.5">{{ $item['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-5 mb-8">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="h-px w-16 bg-gradient-to-r from-transparent to-amber-300"></div>
                <p class="font-body text-xs uppercase tracking-[0.3em] gold">Galería</p>
                <div class="h-px w-16 bg-gradient-to-l from-transparent to-amber-300"></div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @foreach($event->photos->reject(fn($p) => $cover && $p->id === $cover->id)->take(9) as $photo)
                    <div class="aspect-square overflow-hidden rounded-sm">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ── GIFTS ── --}}
    @if($event->gifts)
    <div class="fade-up delay-5 mb-8 w-full">
        <div class="border border-amber-100 bg-white/50 py-5 px-5 rounded-sm text-center">
            <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-1">Mesa de regalos</p>
            <p class="font-display text-2xl text-stone-700 mb-1">{{ $event->gifts_title ?? 'Tu presencia es el mejor regalo' }}</p>
            @if($event->gifts_subtitle)
                <p class="font-body text-sm text-stone-500 mb-4">{{ $event->gifts_subtitle }}</p>
            @endif
            @php $giftCols = count($event->gifts) === 1 ? 'minmax(0,320px)' : 'repeat(auto-fit,minmax(200px,1fr))'; @endphp
            <div style="display:grid;grid-template-columns:{{ $giftCols }};gap:12px;max-width:800px;margin:16px auto 0;">
                @foreach($event->gifts as $gift)
                    @if(!empty($gift['url']))
                        <a href="{{ $gift['url'] }}" target="_blank" rel="noopener"
                           style="display:block;border:1px solid #e7d9c4;border-radius:4px;padding:16px;text-decoration:none;transition:background 0.2s;background:white;">
                    @else
                        <div style="border:1px solid #e7d9c4;border-radius:4px;padding:16px;background:white;">
                    @endif
                        <p class="font-display text-lg" style="color:#c9a96e;">{{ $gift['title'] }}</p>
                        @if(!empty($gift['description']))
                            <p class="font-body text-xs text-stone-400 mt-1" style="letter-spacing:0.1em;">{{ $gift['description'] }}</p>
                        @endif
                        @if(!empty($gift['url']))
                            <p class="font-body text-xs mt-2" style="color:#c9a96e;letter-spacing:0.2em;">VER →</p>
                        @endif
                    @if(!empty($gift['url']))</a>@else</div>@endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { background:#c9a96e22 !important; border-color:#c9a96e !important; font-weight:600; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; cursor:pointer; }
    </style>
    <div class="fade-up delay-5 mb-8">
        <div class="border border-amber-100 bg-white/50 py-5 px-5 rounded-sm text-center">
            <p class="font-body text-xs uppercase tracking-[0.3em] gold mb-1">Confirma tu asistencia</p>
            <p class="font-display text-2xl text-stone-700 mb-4">¿Nos acompañarás?</p>
            <form id="rsvp-form" novalidate>
                <div style="margin-bottom:10px;">
                    <input id="rsvp-name" type="text" placeholder="Tu nombre completo" autocomplete="name"
                           style="width:100%;border:1px solid #e7d9c4;border-radius:4px;padding:8px 12px;font-size:0.875rem;outline:none;font-family:inherit;">
                </div>
                <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                    <button type="button" class="rsvp-opt" data-val="yes"
                            style="flex:1;padding:8px;border:1px solid #e7d9c4;border-radius:4px;font-size:0.8rem;background:transparent;cursor:pointer;color:#92400e;font-family:inherit;transition:all 0.2s;">
                        Sí, ahí estaré
                    </button>
                    <button type="button" class="rsvp-opt" data-val="no"
                            style="flex:1;padding:8px;border:1px solid #e7d9c4;border-radius:4px;font-size:0.8rem;background:transparent;cursor:pointer;color:#78716c;font-family:inherit;transition:all 0.2s;">
                        No podré
                    </button>
                </div>
                <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                    <span style="font-size:0.8rem;color:#78716c;">Invitados:</span>
                    <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid #e7d9c4;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#92400e;">−</button>
                    <span id="g-count" style="font-size:1rem;color:#44403c;min-width:20px;text-align:center;">1</span>
                    <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid #c9a96e;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#92400e;">+</button>
                </div>
                <button type="submit" id="rsvp-btn" disabled
                        style="width:100%;padding:10px;background:#c9a96e;color:white;border:none;border-radius:4px;font-size:0.875rem;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;">
                    Enviar confirmación
                </button>
            </form>
            <div id="rsvp-thanks" style="display:none;padding:16px 0;">
                <p style="font-size:1.5rem;color:#c9a96e;">✓</p>
                <h3 id="thanks-title" class="font-display text-xl text-stone-700 mt-1"></h3>
                <p id="thanks-body" class="font-body text-sm text-stone-500 mt-2"></p>
            </div>
            @if($event->rsvp_whatsapp)
            <div style="margin-top:18px;padding-top:18px;border-top:1px solid #e7d9c4;text-align:center;">
                <p class="font-body text-xs text-stone-500" style="margin-bottom:10px;">Confirma tu asistencia al siguiente WhatsApp</p>
                <a href="https://wa.me/{{ $event->rsvp_whatsapp }}?text={{ rawurlencode('¡Hola! Quiero confirmar mi asistencia a '.$event->name) }}"
                   target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:#25D366;color:#fff;border-radius:4px;font-size:0.85rem;text-decoration:none;font-family:inherit;">
                    <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor;flex-shrink:0;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.149-.15.347-.39.52-.585.173-.198.232-.347.347-.578.116-.232.058-.43-.04-.578-.099-.149-.669-1.612-.916-2.207-.242-.58-.487-.501-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.05 3.131 4.966 4.266 2.917 1.135 2.917.756 3.444.71.528-.05 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.116 1.524 5.84L0 24l6.304-1.484A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.78 9.78 0 01-5.07-1.407l-.364-.218-3.74.88.89-3.642-.238-.374A9.76 9.76 0 012.182 12C2.182 6.586 6.586 2.182 12 2.182S21.818 6.586 21.818 12 17.414 21.818 12 21.818z"/></svg>
                    Confirmar por WhatsApp
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Cierre --}}
    <div class="fade-up delay-5">
        <p class="font-display italic text-2xl gold">Con amor,</p>
        <p class="font-display text-3xl text-stone-700 mt-1">{{ $event->name }}</p>
        <p class="font-display text-3xl gold mt-4 opacity-40">· · ·</p>
    </div>

</div>

<script>
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '18:00' }}');
    function update() {
        const diff = eventDate - Date.now();
        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p class="col-span-4 font-display italic text-2xl" style="color:#c9a96e">¡Hoy es el gran día! 💍</p>';
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
