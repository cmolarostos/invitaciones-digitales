<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} · XV Años</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sage:       #87a878;
            --pink:       #f5c2c7;
            --cream:      #fef9f0;
            --terracotta: #d68c7a;
        }

        body {
            background-color: #f3f4f6;
            font-family: 'Lato', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 2rem 1rem;
        }

        .invitation-card {
            width: 100%;
            max-width: 430px;
            background: var(--cream);
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1),
                        inset 0 0 100px rgba(135,168,120,0.05);
            border: 1px solid rgba(135,168,120,0.2);
            border-radius: 4px;
        }

        .invitation-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("https://www.transparenttextures.com/patterns/cream-paper.png");
            opacity: 0.4;
            pointer-events: none;
            z-index: 0;
        }

        .content { position: relative; z-index: 1; }

        .serif-font {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        .leaf {
            position: absolute;
            width: 40px;
            height: 20px;
            background: var(--sage);
            border-radius: 0 100% 0 100%;
            opacity: 0.6;
        }

        /* Countdown */
        .cd-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cd-num {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 2rem;
            color: var(--terracotta);
            line-height: 1;
        }
        .cd-label {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            color: var(--sage);
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Galería */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }
        .gallery-grid img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="invitation-card p-8 text-center relative">

    {{-- Hojas decorativas --}}
    <div class="leaf top-4 left-4"    style="transform: rotate(45deg)"></div>
    <div class="leaf top-10 left-2"   style="transform: rotate(-12deg) scale(0.75)"></div>
    <div class="leaf top-4 right-4"   style="transform: rotate(-45deg)"></div>
    <div class="leaf bottom-4 left-4" style="transform: rotate(-45deg)"></div>
    <div class="leaf bottom-4 right-4"style="transform: rotate(45deg)"></div>

    <div class="content">

        {{-- Header --}}
        <header class="mt-12 fade-up delay-1">
            <span style="color:var(--terracotta); letter-spacing:0.2em; font-size:0.75rem; font-weight:300; text-transform:uppercase;">
                Mis Quince Años
            </span>

            {{-- Foto de portada circular --}}
            @if($cover = $event->coverPhoto())
                <div class="scale-in delay-2" style="margin: 1.5rem auto; width: 120px; height: 120px;
                            border-radius: 50%; overflow: hidden;
                            border: 3px solid var(--pink);
                            box-shadow: 0 4px 16px rgba(214,140,122,0.2);">
                    <img src="{{ $cover->url }}" alt="{{ $event->name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                </div>
            @endif

            <h1 class="serif-font" style="font-size:3rem; margin-top:1rem; margin-bottom:0.5rem; color:var(--sage);">
                {{ $event->name }}
            </h1>
        </header>

        {{-- Ornamento SVG --}}
        <div class="fade-in delay-2" style="display:flex; justify-content:center; margin: 1.5rem 0;">
            <svg width="120" height="40" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 20C30 10 40 30 60 20C80 10 90 30 110 20" stroke="#f5c2c7" stroke-width="2" stroke-linecap="round"/>
                <circle cx="60" cy="20" r="4" fill="#d68c7a"/>
                <path d="M55 15C52 10 58 8 60 12M65 15C68 10 62 8 60 12" stroke="#87a878" stroke-width="1.5"/>
            </svg>
        </div>

        {{-- Fecha --}}
        <div class="fade-up delay-3" style="background:rgba(245,194,199,0.15); padding: 1rem 1.5rem; border-radius:999px;
                    border: 1px solid rgba(245,194,199,0.4); color:var(--sage); font-weight:300; margin-bottom:1.5rem;">
            <p style="font-size:1.2rem;">
                {{ $event->event_date->translatedFormat('l, d \d\e F') }}
            </p>
            <p style="font-size:0.85rem; letter-spacing:0.2em;">
                {{ $event->event_date->format('Y') }}
            </p>
        </div>

        {{-- Cuenta regresiva --}}
        <div class="fade-up delay-4" style="display:flex; justify-content:center; gap:1.5rem; margin-bottom:1.5rem;"
             id="countdown">
            <div class="cd-box"><span class="cd-num" id="cd-days">--</span><span class="cd-label">Días</span></div>
            <div class="cd-box"><span class="cd-num" id="cd-hours">--</span><span class="cd-label">Horas</span></div>
            <div class="cd-box"><span class="cd-num" id="cd-mins">--</span><span class="cd-label">Min</span></div>
            <div class="cd-box"><span class="cd-num" id="cd-secs">--</span><span class="cd-label">Seg</span></div>
        </div>

        {{-- Lugar --}}
        <section class="fade-up delay-5" style="color:var(--sage); font-weight:300; margin-bottom:1.5rem;">
            @if($event->venue_name)
                <h3 class="serif-font" style="font-size:1.5rem; color:var(--terracotta);">
                    {{ $event->venue_name }}
                </h3>
            @endif
            @if($event->venue_address)
                <p style="font-size:0.875rem; margin-top:0.25rem;">{{ $event->venue_address }}</p>
            @endif
            @if($event->event_time)
                <p style="font-size:1.1rem; margin-top:0.5rem;">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
            @endif
            @if($event->venue_maps_url)
                <a href="{{ $event->venue_maps_url }}" target="_blank"
                   style="display:inline-block; margin-top:0.5rem; font-size:0.75rem;
                          color:var(--terracotta); text-decoration:underline;">
                    📍 Ver en el mapa
                </a>
            @endif
        </section>

        {{-- Dress code --}}
        @if($event->dress_code)
            <div class="fade-up delay-5" style="margin-bottom:1.5rem; font-size:0.85rem; color:var(--sage); font-weight:300;">
                <span style="letter-spacing:0.15em; text-transform:uppercase; font-size:0.7rem;">Vestimenta</span>
                <p class="serif-font" style="font-size:1.2rem; color:var(--terracotta); margin-top:0.25rem;">
                    {{ $event->dress_code }}
                </p>
                @if($event->dress_code_colors)
                    <div style="margin-top:14px; text-align:center;">
                        <p style="letter-spacing:0.12em; text-transform:uppercase; font-size:0.65rem; color:var(--sage); margin-bottom:8px;">Por favor evita estos colores</p>
                        <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                            @foreach($event->dress_code_colors as $color)
                                <div title="{{ $color['label'] ?? '' }}"
                                     style="width:28px;height:28px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.1);position:relative;">
                                    <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid var(--terracotta);background:linear-gradient(45deg,transparent calc(50% - 0.5px),var(--terracotta) 50%,transparent calc(50% + 0.5px));display:block;"></span>
                                </div>
                            @endforeach
                        </div>
                        <p style="font-size:0.68rem; color:var(--terracotta); margin-top:8px; letter-spacing:0.08em;">Reservados para la festejada</p>
                        @if($event->dress_code_colors_note)
                            <p style="font-size:0.72rem; color:var(--sage); margin-top:4px; font-style:italic;">{{ $event->dress_code_colors_note }}</p>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        {{-- Itinerario --}}
        @if($event->itinerary)
            <div class="fade-up delay-5" style="margin-bottom:1.5rem; text-align:left;">
                <p style="letter-spacing:0.15em; text-transform:uppercase; font-size:0.7rem; color:var(--terracotta); text-align:center; margin-bottom:1rem;">Itinerario</p>
                <div style="border:1px solid rgba(214,140,122,0.25); border-radius:8px; overflow:hidden;">
                    @foreach($event->itinerary as $item)
                        <div style="display:flex; gap:0.75rem; padding:0.75rem 1rem; {{ !$loop->last ? 'border-bottom:1px solid rgba(214,140,122,0.15);' : '' }}">
                            @if(!empty($item['time']))
                                <span style="font-size:0.75rem; color:var(--terracotta); white-space:nowrap; padding-top:2px;">{{ \Carbon\Carbon::parse($item['time'])->format('g:i A') }}</span>
                            @endif
                            <div>
                                <p class="serif-font" style="font-size:1rem; color:var(--sage);">{{ $item['title'] }}</p>
                                @if(!empty($item['description']))
                                    <p style="font-size:0.78rem; color:var(--sage); opacity:0.75; margin-top:2px;">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Ornamento separador --}}
        <div class="fade-in delay-6" style="display:flex; justify-content:center; transform:rotate(180deg); margin-bottom:1.5rem;">
            <svg width="80" height="30" viewBox="0 0 120 40" fill="none">
                <path d="M20 20C40 15 50 25 60 20C70 15 80 25 100 20" stroke="#f5c2c7" stroke-width="1.5"/>
            </svg>
        </div>

        {{-- Galería --}}
        @if($event->photos->count() > 1)
            <div class="gallery-grid fade-in delay-6" style="margin-bottom:1.5rem;">
                @foreach($event->photos->skip(1)->take(6) as $photo)
                    <img src="{{ $photo->url }}" alt="">
                @endforeach
            </div>
        @endif

        {{-- Notas / cita --}}
        @if($event->notes)
            <p class="fade-up delay-7" style="font-style:italic; font-size:0.8rem; color:var(--sage); opacity:0.85; margin-bottom:1.5rem; line-height:1.6;">
                "{{ $event->notes }}"
            </p>
        @else
            <p class="fade-up delay-7" style="font-style:italic; font-size:0.8rem; color:var(--sage); opacity:0.8; margin-bottom:1.5rem; line-height:1.6;">
                "Bajo la sombra de los árboles y el aroma de las flores,<br>celebremos juntos este inicio."
            </p>
        @endif

        {{-- ── GIFTS ── --}}
        @if($event->gifts)
        <div class="fade-up delay-5" style="margin-bottom:1.5rem; text-align:center;">
            <span style="letter-spacing:0.15em; text-transform:uppercase; font-size:0.7rem; color:var(--terracotta);">Mesa de regalos</span>
            <p class="serif-font" style="font-size:1.1rem; color:var(--sage); margin-top:0.25rem;">{{ $event->gifts_title ?? 'Tu presencia es el mejor regalo' }}</p>
            @if($event->gifts_subtitle)
                <p style="font-size:0.78rem; color:var(--sage); opacity:0.75; margin-top:4px;">{{ $event->gifts_subtitle }}</p>
            @endif
            @php $giftCols = count($event->gifts) === 1 ? 'minmax(0,300px)' : 'repeat(auto-fit,minmax(170px,1fr))'; @endphp
            <div style="display:grid;grid-template-columns:{{ $giftCols }};gap:10px;max-width:700px;margin:14px auto 0;">
                @foreach($event->gifts as $gift)
                    @if(!empty($gift['url']))
                        <a href="{{ $gift['url'] }}" target="_blank" rel="noopener"
                           style="display:block;border:1px solid rgba(214,140,122,0.35);border-radius:10px;padding:14px;text-decoration:none;background:rgba(255,255,255,0.6);transition:background 0.2s;">
                    @else
                        <div style="border:1px solid rgba(214,140,122,0.35);border-radius:10px;padding:14px;background:rgba(255,255,255,0.6);">
                    @endif
                        <p class="serif-font" style="font-size:1rem; color:var(--terracotta);">{{ $gift['title'] }}</p>
                        @if(!empty($gift['description']))
                            <p style="font-size:0.72rem; color:var(--sage); margin-top:4px; opacity:0.8;">{{ $gift['description'] }}</p>
                        @endif
                        @if(!empty($gift['url']))
                            <p style="font-size:0.68rem; color:var(--terracotta); margin-top:8px; letter-spacing:0.1em;">Ver →</p>
                        @endif
                    @if(!empty($gift['url']))</a>@else</div>@endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── RSVP ── --}}
        @if($event->requires_rsvp)
        <style>
            .rsvp-opt.selected { border-color:var(--terracotta) !important; color:var(--terracotta) !important; font-weight:600; }
            #rsvp-btn:not([disabled]) { opacity:1 !important; }
        </style>
        <div class="fade-up delay-6" style="margin-bottom:1.5rem; text-align:center;">
            <span style="letter-spacing:0.15em; text-transform:uppercase; font-size:0.7rem; color:var(--terracotta);">Confirma tu asistencia</span>
            <p class="serif-font" style="font-size:1.1rem; color:var(--sage); margin-top:0.25rem; margin-bottom:1rem;">¿Nos acompañas?</p>
            <form id="rsvp-form" novalidate>
                <div style="margin-bottom:10px;">
                    <input id="rsvp-name" type="text" placeholder="Tu nombre" autocomplete="name"
                           style="width:100%;border:1px solid rgba(214,140,122,0.4);border-radius:8px;padding:8px 12px;font-size:0.875rem;background:rgba(255,255,255,0.7);outline:none;font-family:inherit;color:var(--sage);">
                </div>
                <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                    <button type="button" class="rsvp-opt" data-val="yes"
                            style="flex:1;padding:8px;border:1px solid rgba(214,140,122,0.4);border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:var(--sage);font-family:inherit;transition:all 0.2s;">
                        Sí, ahí estaré 🌸
                    </button>
                    <button type="button" class="rsvp-opt" data-val="no"
                            style="flex:1;padding:8px;border:1px solid rgba(214,140,122,0.4);border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:var(--sage);font-family:inherit;transition:all 0.2s;">
                        No podré
                    </button>
                </div>
                <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                    <span style="font-size:0.8rem;color:var(--sage);">Invitados:</span>
                    <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid rgba(214,140,122,0.4);border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:var(--terracotta);">−</button>
                    <span id="g-count" style="font-size:1rem;color:var(--sage);min-width:20px;text-align:center;">1</span>
                    <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid var(--terracotta);border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:var(--terracotta);">+</button>
                </div>
                <button type="submit" id="rsvp-btn" disabled
                        style="width:100%;padding:10px;background:var(--terracotta);color:white;border:none;border-radius:8px;font-size:0.875rem;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;">
                    Confirmar asistencia
                </button>
            </form>
            <div id="rsvp-thanks" style="display:none;padding:16px 0;">
                <p style="font-size:1.5rem;">🌸</p>
                <h3 id="thanks-title" class="serif-font" style="font-size:1.3rem;color:var(--terracotta);margin-top:4px;"></h3>
                <p id="thanks-body" style="font-size:0.8rem;color:var(--sage);margin-top:8px;"></p>
            </div>
        </div>
        @endif

        {{-- Footer --}}
        <footer class="fade-in delay-7" style="padding-bottom:2rem;">
            <p style="font-size:0.7rem; color:var(--sage); opacity:0.6; letter-spacing:0.15em; text-transform:uppercase;">
                ✦ ✦ ✦
            </p>
        </footer>

    </div>

    {{-- Blobs de fondo --}}
    <div style="position:absolute; bottom:-10px; left:-10px; width:80px; height:80px;
                background:var(--pink); border-radius:50%; filter:blur(40px); opacity:0.2; z-index:0;"></div>
    <div style="position:absolute; top:-10px; right:-10px; width:80px; height:80px;
                background:var(--sage); border-radius:50%; filter:blur(40px); opacity:0.1; z-index:0;"></div>
</div>

<script>
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '19:00' }}');

    function update() {
        const diff = eventDate - Date.now();

        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p style="font-family:Playfair Display,serif;font-style:italic;font-size:1.3rem;color:var(--terracotta);">¡Hoy es el gran día! 🌸</p>';
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
