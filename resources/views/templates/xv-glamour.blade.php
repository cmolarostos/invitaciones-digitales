<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }} · XV Años</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400;1,600&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold:        #c8a96e;
            --gold-light:  #e8d5a3;
            --gold-dark:   #a8843e;
            --rose:        #C875DC;
            --rose-light:  #F2D3F5;
            --cream:       #FDF6FF;
            --dark:        #3D0F55;
            --purple:      #7B3AAF;
            --purple-mid:  #A85BC8;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--cream);
            font-family: 'Lato', sans-serif;
            overflow-x: hidden;
            color: var(--dark);
        }

        /* ── LOADER ── */
        #loader {
            position: fixed;
            inset: 0;
            background: var(--dark);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            transition: opacity 1s ease, visibility 1s ease;
        }
        #loader.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .loader-crown { font-size: 3rem; animation: crownBounce 1.2s ease-in-out infinite; }
        @keyframes crownBounce {
            0%, 100% { transform: translateY(0) rotate(-5deg); }
            50%       { transform: translateY(-12px) rotate(5deg); }
        }
        .loader-ring {
            width: 80px; height: 80px;
            border: 3px solid rgba(200,169,110,0.2);
            border-top-color: var(--gold);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loader-text {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            color: var(--gold);
            opacity: 0;
            animation: fadeUp 1s 0.6s forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── FLOATING PETALS ── */
        .float-el {
            position: fixed;
            pointer-events: none;
            z-index: 2;
            animation: floatDown linear infinite;
        }
        @keyframes floatDown {
            0%   { transform: translateY(-60px) rotate(0deg);   opacity: 0; }
            8%   { opacity: 0.8; }
            90%  { opacity: 0.8; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        /* ── SHARED TYPOGRAPHY ── */
        .section-label {
            display: block;
            font-size: 0.78rem;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.6rem;
        }
        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.9rem, 5vw, 3.2rem);
            font-style: italic;
        }
        .gold-bar {
            width: 70px; height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 1rem auto;
        }

        section { padding: 5.5rem 1.5rem; }
        .section-header { text-align: center; margin-bottom: 3.5rem; }

        /* ── HERO ── */
        #hero {
            min-height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(155deg,
                #3D0F55 0%, #6A22A0 25%,
                #9B40B8 55%, #C875DC 80%,
                #E0AAEC 100%);
        }
        .hero-mesh {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 30%, rgba(200,169,110,.18) 0%, transparent 70%),
                radial-gradient(ellipse 50% 60% at 80% 70%, rgba(200,131,220,.25) 0%, transparent 70%);
            animation: meshShift 8s ease-in-out infinite alternate;
        }
        @keyframes meshShift {
            from { opacity: 0.8; transform: scale(1); }
            to   { opacity: 1;   transform: scale(1.08); }
        }
        .hero-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(200,169,110,.12);
            animation: ringPulse 6s ease-in-out infinite;
        }
        .hero-circle:nth-child(1) { width: 500px; height: 500px; top: 50%; left: 50%; transform: translate(-50%,-50%); }
        .hero-circle:nth-child(2) { width: 700px; height: 700px; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 1s; }
        .hero-circle:nth-child(3) { width: 900px; height: 900px; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 2s; }
        @keyframes ringPulse {
            0%, 100% { opacity: 0.4; }
            50%       { opacity: 0.9; }
        }
        .hero-content {
            position: relative;
            z-index: 4;
            text-align: center;
            padding: 2rem;
            animation: heroIn 1.8s cubic-bezier(0.22,1,0.36,1) forwards;
        }
        @keyframes heroIn {
            from { opacity: 0; transform: translateY(50px) scale(0.95); }
            to   { opacity: 1; transform: none; }
        }
        .hero-eyebrow {
            font-size: 0.82rem;
            letter-spacing: 8px;
            text-transform: uppercase;
            color: var(--gold-light);
            margin-bottom: 1.2rem;
            font-weight: 300;
        }
        .hero-crown { font-size: 2.5rem; display: block; margin-bottom: 0.8rem; animation: crownFloat 4s ease-in-out infinite; }
        @keyframes crownFloat {
            0%, 100% { transform: translateY(0) rotate(-4deg); }
            50%       { transform: translateY(-8px) rotate(4deg); }
        }
        .hero-photo {
            width: 160px; height: 160px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.5rem;
            display: block;
            border: 4px solid rgba(200,169,110,.6);
            box-shadow: 0 0 40px rgba(200,169,110,.3), 0 0 80px rgba(200,117,220,.2);
        }
        .hero-name {
            font-family: 'Dancing Script', cursive;
            font-size: clamp(4rem, 18vw, 10rem);
            color: #fff;
            line-height: 1;
            text-shadow: 0 0 40px rgba(200,169,110,.55), 0 0 80px rgba(200,169,110,.2);
            margin-bottom: 0.8rem;
        }
        .hero-xv {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.1rem, 4vw, 2rem);
            color: var(--gold);
            letter-spacing: 10px;
            text-transform: uppercase;
            margin-bottom: 1.8rem;
        }
        .hero-divider {
            width: 160px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto 1.8rem;
        }
        .hero-date {
            font-weight: 300;
            font-size: 1.05rem;
            letter-spacing: 5px;
            color: rgba(255,255,255,.75);
        }
        .hero-scroll {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255,255,255,.5);
            font-size: 0.7rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            animation: scrollBounce 2.4s ease-in-out infinite;
        }
        .hero-scroll-arrow {
            width: 22px; height: 22px;
            border-right: 2px solid var(--gold);
            border-bottom: 2px solid var(--gold);
            transform: rotate(45deg);
        }
        @keyframes scrollBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50%       { transform: translateX(-50%) translateY(9px); }
        }

        /* ── COUNTDOWN ── */
        #countdown {
            background: linear-gradient(135deg, var(--dark), var(--purple));
            text-align: center;
            padding: 4.5rem 1.5rem;
        }
        .cd-label {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            color: var(--gold);
            margin-bottom: 2.5rem;
        }
        .cd-grid {
            display: flex;
            justify-content: center;
            gap: 1.2rem;
            flex-wrap: wrap;
        }
        .cd-item {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(200,169,110,.3);
            border-radius: 18px;
            padding: 1.6rem 1.8rem;
            min-width: 100px;
            backdrop-filter: blur(12px);
            transition: border-color 0.4s;
        }
        .cd-item:hover { border-color: var(--gold); }
        .cd-num {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--gold);
            line-height: 1;
            display: block;
        }
        .cd-unit {
            font-size: 0.72rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255,255,255,.55);
            margin-top: 0.4rem;
            display: block;
        }
        .cd-footer {
            font-family: 'Dancing Script', cursive;
            font-size: 1.6rem;
            color: var(--gold-light);
            margin-top: 2rem;
        }

        /* ── MESSAGE ── */
        #message {
            background: linear-gradient(170deg, #fef5ff 0%, #fff8e6 60%, #f5e8ff 100%);
            text-align: center;
        }
        .msg-quote {
            max-width: 680px;
            margin: 0 auto;
            padding: 3rem 2rem;
            position: relative;
        }
        .msg-quote::before {
            content: '"';
            font-family: 'Dancing Script', cursive;
            font-size: 10rem;
            color: var(--gold);
            opacity: 0.15;
            position: absolute;
            top: -2rem;
            left: 0.5rem;
            line-height: 1;
            pointer-events: none;
        }
        .msg-text {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.05rem, 2.5vw, 1.35rem);
            line-height: 1.9;
            color: var(--dark);
            font-style: italic;
            position: relative;
            z-index: 1;
        }
        .msg-sig {
            margin-top: 2rem;
            font-family: 'Dancing Script', cursive;
            font-size: 2.2rem;
            color: var(--rose);
        }
        .msg-hearts { font-size: 1.5rem; margin-top: 0.8rem; animation: heartbeat 1.8s ease-in-out infinite; }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25%       { transform: scale(1.2); }
            40%       { transform: scale(1); }
        }

        /* ── DETAILS ── */
        #details { background: var(--cream); }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.8rem;
            max-width: 960px;
            margin: 0 auto;
        }
        .detail-card {
            background: #fff;
            border-radius: 22px;
            padding: 2.5rem 1.8rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,.05);
            border: 1px solid rgba(200,169,110,.18);
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .detail-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 60px rgba(200,169,110,.22);
        }
        .detail-icon { font-size: 2.6rem; margin-bottom: 1rem; display: block; }
        .detail-card h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            color: var(--dark);
            margin-bottom: 0.6rem;
        }
        .detail-card p { color: #777; line-height: 1.75; font-size: 0.95rem; }
        .detail-hl { color: var(--gold); font-weight: 700; font-size: 1.1rem; }
        .dc-pill {
            display: inline-block;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            margin-top: 0.8rem;
        }

        /* ── GALLERY ── */
        #gallery { background: #f9f0fc; }
        .gallery-masonry {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 240px;
            gap: 1rem;
        }
        .g-item {
            overflow: hidden;
            border-radius: 14px;
            cursor: zoom-in;
            position: relative;
        }
        .g-item:nth-child(1) { grid-row: span 2; }
        .g-item:nth-child(5) { grid-row: span 2; }
        .g-item:nth-child(8) { grid-column: span 2; }
        .g-item img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform .65s ease, filter .65s ease;
            filter: brightness(.9) saturate(1.05);
        }
        .g-item:hover img { transform: scale(1.12); filter: brightness(1) saturate(1.15); }
        .g-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(200,169,110,.15), rgba(200,131,220,.28));
            opacity: 0;
            transition: opacity .4s;
        }
        .g-item:hover::after { opacity: 1; }

        /* lightbox */
        #lightbox {
            position: fixed;
            inset: 0;
            background: rgba(42,8,70,.92);
            z-index: 8000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity .4s, visibility .4s;
        }
        #lightbox.open { opacity: 1; visibility: visible; }
        #lightbox img {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 30px 80px rgba(0,0,0,.6);
            transform: scale(0.9);
            transition: transform .4s cubic-bezier(0.22,1,0.36,1);
        }
        #lightbox.open img { transform: scale(1); }
        #lightbox-close {
            position: absolute;
            top: 1.5rem; right: 1.5rem;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(200,169,110,.3);
            border: none;
            width: 50px; height: 50px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: background .3s;
        }
        #lightbox-close:hover { background: var(--gold); }

        /* ── LOCATION ── */
        #location { background: var(--cream); }
        .loc-card {
            max-width: 720px;
            margin: 0 auto;
            background: #fff;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
        }
        .loc-map {
            height: 260px;
            background: linear-gradient(135deg, #F2D3F5 0%, #DDB8F0 50%, #e8d5f5 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }
        .loc-map::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, rgba(200,169,110,.08) 0px, rgba(200,169,110,.08) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(90deg, rgba(200,169,110,.08) 0px, rgba(200,169,110,.08) 1px, transparent 1px, transparent 40px);
        }
        .loc-pin {
            font-size: 3.5rem;
            position: relative;
            z-index: 1;
            animation: pinBounce 2.5s ease-in-out infinite;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,.2));
        }
        @keyframes pinBounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
        .loc-map-label {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            color: var(--dark);
            font-style: italic;
            position: relative;
            z-index: 1;
        }
        .loc-body { padding: 2.2rem; text-align: center; }
        .loc-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        .loc-body p { color: #777; line-height: 1.8; }
        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            padding: 0.85rem 2.2rem;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            transition: transform .3s, box-shadow .3s;
        }
        .map-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(200,169,110,.45); }

        /* ── FOOTER ── */
        footer {
            background: var(--dark);
            text-align: center;
            padding: 3.5rem 1.5rem;
            color: rgba(255,255,255,.45);
        }
        .footer-name {
            font-family: 'Dancing Script', cursive;
            font-size: 3rem;
            color: var(--gold);
            display: block;
            margin-bottom: 0.3rem;
        }
        footer .sub {
            font-size: 0.78rem;
            letter-spacing: 4px;
            text-transform: uppercase;
        }
        footer .hearts {
            font-size: 1.2rem;
            margin-top: 1rem;
            display: block;
            opacity: .6;
        }

        @media (max-width: 768px) {
            .gallery-masonry {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 180px;
            }
            .g-item:nth-child(8) { grid-column: span 1; }
        }
        @media (max-width: 480px) {
            .gallery-masonry {
                grid-template-columns: 1fr;
                grid-auto-rows: 220px;
            }
            .g-item:nth-child(1),
            .g-item:nth-child(5) { grid-row: span 1; }
            .cd-item { padding: 1rem 1.2rem; min-width: 72px; }
            .cd-num { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    {{-- ── LOADER ── --}}
    <div id="loader">
        <div class="loader-crown">👑</div>
        <div class="loader-ring"></div>
        <div class="loader-text">{{ $event->name }} · XV Años</div>
    </div>

    {{-- ── LIGHTBOX ── --}}
    @if($event->photos->count() > 1)
    <div id="lightbox">
        <button id="lightbox-close" aria-label="Cerrar">✕</button>
        <img id="lightbox-img" src="" alt="Foto ampliada">
    </div>
    @endif

    {{-- ── HERO ── --}}
    <section id="hero">
        <div class="hero-mesh"></div>
        <div class="hero-circle"></div>
        <div class="hero-circle"></div>
        <div class="hero-circle"></div>

        <div class="hero-content">
            <p class="hero-eyebrow">Con todo mi amor te invito a celebrar</p>
            <span class="hero-crown">👑</span>

            @if($cover = $event->coverPhoto())
                <img src="{{ $cover->url }}" alt="{{ $event->name }}" class="hero-photo">
            @endif

            <h1 class="hero-name">{{ $event->name }}</h1>
            <p class="hero-xv">✦ &nbsp; XV Años &nbsp; ✦</p>
            <div class="hero-divider"></div>
            <p class="hero-date">
                {{ $event->event_date->translatedFormat('d') }}
                &nbsp;·&nbsp;
                {{ ucfirst($event->event_date->translatedFormat('F')) }}
                &nbsp;·&nbsp;
                {{ $event->event_date->format('Y') }}
            </p>
        </div>

        <div class="hero-scroll" aria-hidden="true">
            <span>Desliza</span>
            <div class="hero-scroll-arrow"></div>
        </div>
    </section>

    {{-- ── COUNTDOWN ── --}}
    <div id="countdown">
        <p class="cd-label fade-up">✨ ¡Faltan solo...</p>
        <div class="cd-grid fade-up">
            <div class="cd-item">
                <span class="cd-num" id="cd-days">--</span>
                <span class="cd-unit">Días</span>
            </div>
            <div class="cd-item">
                <span class="cd-num" id="cd-hours">--</span>
                <span class="cd-unit">Horas</span>
            </div>
            <div class="cd-item">
                <span class="cd-num" id="cd-mins">--</span>
                <span class="cd-unit">Minutos</span>
            </div>
            <div class="cd-item">
                <span class="cd-num" id="cd-secs">--</span>
                <span class="cd-unit">Segundos</span>
            </div>
        </div>
        <p class="cd-footer fade-up">...para mi gran noche! 🌟</p>
    </div>

    {{-- ── MENSAJE PERSONAL ── --}}
    <section id="message">
        <div class="section-header fade-up">
            <span class="section-label">Una palabra de {{ $event->name }}</span>
            <h2 class="section-heading">Con todo mi corazón</h2>
            <div class="gold-bar"></div>
        </div>
        <div class="msg-quote fade-up">
            <p class="msg-text">
                @if($event->notes)
                    {{ $event->notes }}
                @else
                    Hoy celebro quince años y quiero compartir este momento tan especial
                    rodeada de las personas que más amo. Cada uno de ustedes es parte
                    de mi historia, y juntos escribiremos esta hermosa página.
                    Los espero con los brazos abiertos para compartir esta noche
                    mágica e inolvidable.
                @endif
            </p>
            <div class="msg-sig">Con amor, {{ $event->name }} 💕</div>
            <div class="msg-hearts">🌸 🦋 🌺</div>
        </div>
    </section>

    {{-- ── DETALLES DEL EVENTO ── --}}
    <section id="details">
        <div class="section-header fade-up">
            <span class="section-label">El Gran Evento</span>
            <h2 class="section-heading">Detalles de la Celebración</h2>
            <div class="gold-bar"></div>
        </div>
        <div class="details-grid">
            <div class="detail-card fade-up">
                <span class="detail-icon">📅</span>
                <h3>Fecha</h3>
                <p class="detail-hl">{{ ucfirst($event->event_date->translatedFormat('l, d \d\e F')) }}</p>
                <p>{{ $event->event_date->format('Y') }}</p>
            </div>
            @if($event->event_time)
            <div class="detail-card fade-up">
                <span class="detail-icon">🕖</span>
                <h3>Hora</h3>
                <p class="detail-hl">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                <p>Llegada de invitados</p>
            </div>
            @endif
            @if($event->venue_name || $event->venue_address)
            <div class="detail-card fade-up">
                <span class="detail-icon">🏛️</span>
                <h3>Lugar</h3>
                @if($event->venue_name)
                    <p class="detail-hl">{{ $event->venue_name }}</p>
                @endif
                @if($event->venue_address)
                    <p>{{ $event->venue_address }}</p>
                @endif
            </div>
            @endif
            @if($event->dress_code)
            <div class="detail-card fade-up">
                <span class="detail-icon">👗</span>
                <h3>Dress Code</h3>
                <div class="dc-pill">{{ $event->dress_code }}</div>
            </div>
            @endif
        </div>
    </section>

    {{-- ── GALERÍA ── --}}
    @if($event->photos->count() > 1)
    <section id="gallery">
        <div class="section-header fade-up">
            <span class="section-label">Momentos especiales</span>
            <h2 class="section-heading">Galería de Recuerdos</h2>
            <div class="gold-bar"></div>
        </div>
        <div class="gallery-masonry">
            @foreach($event->photos->skip(1)->take(9) as $photo)
                <div class="g-item fade-up">
                    <img src="{{ $photo->url }}" alt="" loading="lazy">
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── UBICACIÓN ── --}}
    @if($event->venue_name || $event->venue_address || $event->venue_maps_url)
    <section id="location">
        <div class="section-header fade-up">
            <span class="section-label">¿Cómo llegar?</span>
            <h2 class="section-heading">Ubicación del Evento</h2>
            <div class="gold-bar"></div>
        </div>

        <div class="loc-card fade-up">
            <div class="loc-map">
                <div class="loc-pin">📍</div>
                @if($event->venue_name)
                    <span class="loc-map-label">{{ $event->venue_name }}</span>
                @endif
            </div>
            <div class="loc-body">
                @if($event->venue_name)
                    <h3>{{ $event->venue_name }}</h3>
                @endif
                @if($event->venue_address)
                    <p>{{ $event->venue_address }}</p>
                @endif
                @if($event->venue_maps_url)
                    <a href="{{ $event->venue_maps_url }}" target="_blank" rel="noopener" class="map-btn">
                        📍 Ver en Google Maps
                    </a>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ── FOOTER ── --}}
    <footer>
        <span class="footer-name">{{ $event->name }}</span>
        <p class="sub">
            XV Años &nbsp;·&nbsp;
            {{ ucfirst($event->event_date->translatedFormat('d \d\e F Y')) }}
        </p>
        <span class="hearts">🌸 💕 🦋 ✨ 🌺</span>
        <p style="margin-top:1.5rem; font-size:0.72rem; opacity:.4;">Hecho con amor especialmente para ti</p>
    </footer>

    <script>
    // ── LOADER ──
    window.addEventListener('load', () => {
        setTimeout(() => {
            document.getElementById('loader').classList.add('hidden');
            initPetals();
        }, 1800);
    });

    // ── FLOATING PETALS ──
    function initPetals() {
        const symbols = ['🌸','🌺','✨','⭐','💕','🦋','🌹','💫','🌼'];

        function createPetal() {
            const el = document.createElement('div');
            el.className = 'float-el';
            el.textContent = symbols[Math.floor(Math.random() * symbols.length)];
            el.style.left = Math.random() * 100 + 'vw';
            el.style.fontSize = (Math.random() * 1.2 + 0.7) + 'rem';
            const dur = Math.random() * 8 + 7;
            el.style.animationDuration = dur + 's';
            el.style.animationDelay = (Math.random() * 2) + 's';
            document.body.appendChild(el);
            setTimeout(() => el.remove(), (dur + 3) * 1000);
        }

        for (let i = 0; i < 10; i++) setTimeout(createPetal, i * 350);
        setInterval(createPetal, 1100);
    }

    // ── COUNTDOWN ──
    (function () {
        const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '19:00' }}');
        const grid = document.getElementById('countdown');

        function tick() {
            const diff = eventDate - Date.now();

            if (diff <= 0) {
                grid.querySelector('.cd-grid').innerHTML =
                    '<p style="font-family:Dancing Script,cursive;font-size:1.8rem;color:var(--gold);">¡Hoy es el gran día! 🎉</p>';
                return;
            }

            document.getElementById('cd-days').textContent  = String(Math.floor(diff / 86400000)).padStart(2,'0');
            document.getElementById('cd-hours').textContent = String(Math.floor(diff % 86400000 / 3600000)).padStart(2,'0');
            document.getElementById('cd-mins').textContent  = String(Math.floor(diff % 3600000 / 60000)).padStart(2,'0');
            document.getElementById('cd-secs').textContent  = String(Math.floor(diff % 60000 / 1000)).padStart(2,'0');
        }

        tick();
        setInterval(tick, 1000);
    })();

    // ── LIGHTBOX ──
    @if($event->photos->count() > 1)
    const lightbox    = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');

    document.querySelectorAll('.g-item img').forEach(img => {
        img.addEventListener('click', () => {
            lightboxImg.src = img.src;
            lightbox.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeLightbox() {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.getElementById('lightbox-close').addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
    @endif
    </script>

</body>
</html>
