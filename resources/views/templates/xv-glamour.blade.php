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
            --gold:       #c8a96e;
            --gold-light: #e8d5a3;
            --gold-dark:  #a8843e;
            --rose:       #C875DC;
            --rose-light: #F2D3F5;
            --cream:      #FDF6FF;
            --dark:       #3D0F55;
            --purple:     #7B3AAF;
            --purple-mid: #A85BC8;
        }

        html { scroll-behavior: smooth; }
        body { background: var(--cream); font-family: 'Lato', sans-serif; overflow-x: hidden; color: var(--dark); }

        /* ── LOADER ── */
        #loader {
            position: fixed; inset: 0; background: var(--dark); z-index: 9999;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.5rem;
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
            border: 3px solid rgba(200,169,110,0.2); border-top-color: var(--gold);
            border-radius: 50%; animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loader-text {
            font-family: 'Dancing Script', cursive; font-size: 2rem; color: var(--gold);
            opacity: 0; animation: ldFadeUp 1s 0.6s forwards;
        }
        @keyframes ldFadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── FLOATING PETALS ── */
        .float-el {
            position: fixed; pointer-events: none; z-index: 2;
            animation: floatDown linear infinite;
        }
        @keyframes floatDown {
            0%   { transform: translateY(-60px) rotate(0deg);   opacity: 0; }
            8%   { opacity: 0.8; }
            90%  { opacity: 0.8; }
            100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
        }

        /* ── SHARED ── */
        .section-label {
            display: block; font-size: 0.78rem; letter-spacing: 6px;
            text-transform: uppercase; color: var(--gold); margin-bottom: 0.6rem;
        }
        .section-heading {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.9rem, 5vw, 3.2rem); font-style: italic;
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
            min-height: 100vh; position: relative;
            display: flex; align-items: center; justify-content: center; overflow: hidden;
            background: linear-gradient(155deg, #3D0F55 0%, #6A22A0 25%, #9B40B8 55%, #C875DC 80%, #E0AAEC 100%);
        }
        .hero-mesh {
            position: absolute; inset: 0;
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
            position: absolute; border-radius: 50%;
            border: 1px solid rgba(200,169,110,.12); animation: ringPulse 6s ease-in-out infinite;
        }
        .hero-circle:nth-child(1) { width: 500px; height: 500px; top: 50%; left: 50%; transform: translate(-50%,-50%); }
        .hero-circle:nth-child(2) { width: 700px; height: 700px; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 1s; }
        .hero-circle:nth-child(3) { width: 900px; height: 900px; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: 2s; }
        @keyframes ringPulse {
            0%, 100% { opacity: 0.4; }
            50%       { opacity: 0.9; }
        }
        .hero-content {
            position: relative; z-index: 4; text-align: center; padding: 2rem;
            animation: heroIn 1.8s cubic-bezier(0.22,1,0.36,1) forwards;
        }
        @keyframes heroIn {
            from { opacity: 0; transform: translateY(50px) scale(0.95); }
            to   { opacity: 1; transform: none; }
        }
        .hero-eyebrow {
            font-size: 0.82rem; letter-spacing: 8px; text-transform: uppercase;
            color: var(--gold-light); margin-bottom: 1.2rem; font-weight: 300;
        }
        .hero-crown { font-size: 2.5rem; display: block; margin-bottom: 0.8rem; animation: crownFloat 4s ease-in-out infinite; }
        @keyframes crownFloat {
            0%, 100% { transform: translateY(0) rotate(-4deg); }
            50%       { transform: translateY(-8px) rotate(4deg); }
        }
        .hero-photo {
            width: 160px; height: 160px; border-radius: 50%; object-fit: cover;
            margin: 0 auto 1.5rem; display: block;
            border: 4px solid rgba(200,169,110,.6);
            box-shadow: 0 0 40px rgba(200,169,110,.3), 0 0 80px rgba(200,117,220,.2);
        }
        .hero-name {
            font-family: 'Dancing Script', cursive; font-size: clamp(4rem, 18vw, 10rem);
            color: #fff; line-height: 1;
            text-shadow: 0 0 40px rgba(200,169,110,.55), 0 0 80px rgba(200,169,110,.2);
            margin-bottom: 0.8rem;
        }
        .hero-xv {
            font-family: 'Playfair Display', serif; font-size: clamp(1.1rem, 4vw, 2rem);
            color: var(--gold); letter-spacing: 10px; text-transform: uppercase; margin-bottom: 1.8rem;
        }
        .hero-divider {
            width: 160px; height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto 1.8rem;
        }
        .hero-date { font-weight: 300; font-size: 1.05rem; letter-spacing: 5px; color: rgba(255,255,255,.75); }
        .hero-scroll {
            position: absolute; bottom: 2.5rem; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 0.4rem;
            color: rgba(255,255,255,.5); font-size: 0.7rem; letter-spacing: 4px; text-transform: uppercase;
            animation: scrollBounce 2.4s ease-in-out infinite;
        }
        .hero-scroll-arrow {
            width: 22px; height: 22px;
            border-right: 2px solid var(--gold); border-bottom: 2px solid var(--gold);
            transform: rotate(45deg);
        }
        @keyframes scrollBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50%       { transform: translateX(-50%) translateY(9px); }
        }

        /* ── COUNTDOWN ── */
        #countdown { background: linear-gradient(135deg, var(--dark), var(--purple)); text-align: center; padding: 4.5rem 1.5rem; }
        .cd-label { font-family: 'Dancing Script', cursive; font-size: 2rem; color: var(--gold); margin-bottom: 2.5rem; }
        .cd-grid { display: flex; justify-content: center; gap: 1.2rem; flex-wrap: wrap; }
        .cd-item {
            background: rgba(255,255,255,.06); border: 1px solid rgba(200,169,110,.3);
            border-radius: 18px; padding: 1.6rem 1.8rem; min-width: 100px;
            backdrop-filter: blur(12px); transition: border-color 0.4s;
        }
        .cd-item:hover { border-color: var(--gold); }
        .cd-num { font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--gold); line-height: 1; display: block; }
        .cd-unit { font-size: 0.72rem; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,.55); margin-top: 0.4rem; display: block; }
        .cd-footer { font-family: 'Dancing Script', cursive; font-size: 1.6rem; color: var(--gold-light); margin-top: 2rem; }

        /* ── MESSAGE ── */
        #message { background: linear-gradient(170deg, #fef5ff 0%, #fff8e6 60%, #f5e8ff 100%); text-align: center; }
        .msg-quote { max-width: 680px; margin: 0 auto; padding: 3rem 2rem; position: relative; }
        .msg-quote::before {
            content: '"'; font-family: 'Dancing Script', cursive; font-size: 10rem;
            color: var(--gold); opacity: 0.15; position: absolute; top: -2rem; left: 0.5rem;
            line-height: 1; pointer-events: none;
        }
        .msg-text {
            font-family: 'Playfair Display', serif; font-size: clamp(1.05rem, 2.5vw, 1.35rem);
            line-height: 1.9; color: var(--dark); font-style: italic; position: relative; z-index: 1;
        }
        .msg-sig { margin-top: 2rem; font-family: 'Dancing Script', cursive; font-size: 2.2rem; color: var(--rose); }
        .msg-hearts { font-size: 1.5rem; margin-top: 0.8rem; animation: heartbeat 1.8s ease-in-out infinite; }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25%       { transform: scale(1.2); }
            40%       { transform: scale(1); }
        }

        /* ── DETAILS ── */
        #details { background: var(--cream); }
        .details-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.8rem; max-width: 960px; margin: 0 auto;
        }
        .detail-card {
            background: #fff; border-radius: 22px; padding: 2.5rem 1.8rem; text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,.05); border: 1px solid rgba(200,169,110,.18);
            transition: transform .35s ease, box-shadow .35s ease;
        }
        .detail-card:hover { transform: translateY(-10px); box-shadow: 0 24px 60px rgba(200,169,110,.22); }
        .detail-icon { font-size: 2.6rem; margin-bottom: 1rem; display: block; }
        .detail-card h3 { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--dark); margin-bottom: 0.6rem; }
        .detail-card p { color: #777; line-height: 1.75; font-size: 0.95rem; }
        .detail-hl { color: var(--gold); font-weight: 700; font-size: 1.1rem; }
        .dc-pill {
            display: inline-block; background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white; font-size: 0.78rem; font-weight: 700; letter-spacing: 2px;
            text-transform: uppercase; padding: 0.4rem 1rem; border-radius: 50px; margin-top: 0.8rem;
        }

        /* ── GALLERY (masonry) ── */
        #gallery { background: #f9f0fc; }
        .gallery-masonry {
            max-width: 1100px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); grid-auto-rows: 240px; gap: 1rem;
        }
        .g-item { overflow: hidden; border-radius: 14px; cursor: zoom-in; position: relative; }
        .g-item:nth-child(1) { grid-row: span 2; }
        .g-item:nth-child(5) { grid-row: span 2; }
        .g-item:nth-child(8) { grid-column: span 2; }
        .g-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .65s ease, filter .65s ease; filter: brightness(.9) saturate(1.05); }
        .g-item:hover img { transform: scale(1.12); filter: brightness(1) saturate(1.15); }
        .g-item::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(200,169,110,.15), rgba(200,131,220,.28));
            opacity: 0; transition: opacity .4s;
        }
        .g-item:hover::after { opacity: 1; }

        /* ── LIGHTBOX ── */
        #lightbox {
            position: fixed; inset: 0; background: rgba(42,8,70,.92); z-index: 8000;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: opacity .4s, visibility .4s;
        }
        #lightbox.open { opacity: 1; visibility: visible; }
        #lightbox img {
            max-width: 90vw; max-height: 85vh; object-fit: contain; border-radius: 12px;
            box-shadow: 0 30px 80px rgba(0,0,0,.6); transform: scale(0.9);
            transition: transform .4s cubic-bezier(0.22,1,0.36,1);
        }
        #lightbox.open img { transform: scale(1); }
        #lightbox-close {
            position: absolute; top: 1.5rem; right: 1.5rem; color: white; font-size: 2rem; cursor: pointer;
            background: rgba(200,169,110,.3); border: none; width: 50px; height: 50px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            transition: background .3s;
        }
        #lightbox-close:hover { background: var(--gold); }

        /* ── CAROUSEL ── */
        #carousel-section {
            background: linear-gradient(140deg, var(--dark) 0%, var(--purple) 60%, var(--rose) 100%);
            padding: 5.5rem 1.5rem;
        }
        #carousel-section .section-label  { color: rgba(200,169,110,.85); }
        #carousel-section .section-heading { color: #fff; }
        #carousel-section .gold-bar { opacity: .7; }

        .c-wrap {
            position: relative; max-width: 820px; margin: 0 auto;
            overflow: hidden; border-radius: 22px; box-shadow: 0 40px 100px rgba(0,0,0,.55);
        }
        .c-track { display: flex; transition: transform .65s cubic-bezier(0.25,0.46,0.45,0.94); }
        .c-slide { min-width: 100%; aspect-ratio: 4/3; position: relative; }
        .c-slide img { width: 100%; height: 100%; object-fit: cover; }
        .c-caption {
            position: absolute; bottom: 0; left: 0; right: 0;
            padding: 2.5rem 2rem 1.8rem;
            background: linear-gradient(transparent, rgba(42,8,70,.75));
            color: white; text-align: center;
        }
        .c-caption span { font-family: 'Dancing Script', cursive; font-size: 1.6rem; text-shadow: 0 2px 8px rgba(0,0,0,.5); }
        .c-btn {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 52px; height: 52px; border-radius: 50%; border: none;
            background: rgba(200,169,110,.75); backdrop-filter: blur(8px);
            color: white; font-size: 1.3rem; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .3s, transform .3s; z-index: 10;
        }
        .c-btn:hover { background: var(--gold); transform: translateY(-50%) scale(1.12); }
        .c-btn.prev { left: 1rem; }
        .c-btn.next { right: 1rem; }
        .c-dots { display: flex; justify-content: center; gap: 0.55rem; margin-top: 1.8rem; }
        .c-dot {
            width: 9px; height: 9px; border-radius: 50%; border: none;
            background: rgba(200,169,110,.35); cursor: pointer; transition: all .35s ease;
        }
        .c-dot.active { background: var(--gold); width: 26px; border-radius: 5px; }

        /* ── TIMELINE ── */
        #timeline { background: var(--cream); }
        .tl-wrap { max-width: 700px; margin: 0 auto; position: relative; }
        .tl-wrap::before {
            content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 2px;
            background: linear-gradient(to bottom, transparent, var(--gold), var(--gold), transparent);
            transform: translateX(-50%);
        }
        .tl-item { display: flex; gap: 2rem; margin-bottom: 3rem; position: relative; }
        .tl-item:nth-child(even) { flex-direction: row-reverse; }
        .tl-dot {
            position: absolute; left: 50%; top: 1.2rem; transform: translateX(-50%);
            width: 16px; height: 16px; background: var(--gold); border-radius: 50%;
            border: 3px solid var(--cream); box-shadow: 0 0 0 3px var(--gold); z-index: 1;
        }
        .tl-card {
            width: calc(50% - 2rem); background: #fff; border-radius: 16px;
            padding: 1.4rem 1.6rem; box-shadow: 0 6px 24px rgba(0,0,0,.06);
            border: 1px solid rgba(200,169,110,.15);
        }
        .tl-time { font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 0.3rem; }
        .tl-card h4 { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--dark); margin-bottom: 0.25rem; }
        .tl-card p { color: #888; font-size: 0.9rem; }

        /* ── LOCATION ── */
        #location { background: #f9f0fc; }
        .loc-card { max-width: 720px; margin: 0 auto; background: #fff; border-radius: 26px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.08); }
        .loc-map {
            height: 260px;
            background: linear-gradient(135deg, #F2D3F5 0%, #DDB8F0 50%, #e8d5f5 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 1rem; position: relative; overflow: hidden;
        }
        .loc-map::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                repeating-linear-gradient(0deg, rgba(200,169,110,.08) 0px, rgba(200,169,110,.08) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(90deg, rgba(200,169,110,.08) 0px, rgba(200,169,110,.08) 1px, transparent 1px, transparent 40px);
        }
        .loc-pin {
            font-size: 3.5rem; position: relative; z-index: 1;
            animation: pinBounce 2.5s ease-in-out infinite;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,.2));
        }
        @keyframes pinBounce {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
        .loc-map-label { font-family: 'Playfair Display', serif; font-size: 1.25rem; color: var(--dark); font-style: italic; position: relative; z-index: 1; }
        .loc-body { padding: 2.2rem; text-align: center; }
        .loc-body h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--dark); margin-bottom: 0.5rem; }
        .loc-body p { color: #777; line-height: 1.8; }
        .loc-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; justify-content: center; margin: 1.2rem 0; }
        .loc-chip {
            background: rgba(200,169,110,.1); border: 1px solid rgba(200,169,110,.3);
            color: var(--gold-dark); font-size: 0.82rem; padding: 0.3rem 0.9rem; border-radius: 50px;
        }
        .map-btn {
            display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 0.8rem;
            padding: 0.85rem 2.2rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white; border-radius: 50px; text-decoration: none;
            font-weight: 700; font-size: 0.9rem; letter-spacing: 1px;
            transition: transform .3s, box-shadow .3s;
        }
        .map-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(200,169,110,.45); }

        /* ── FOOTER ── */
        footer { background: var(--dark); text-align: center; padding: 3.5rem 1.5rem; color: rgba(255,255,255,.45); }
        .footer-name { font-family: 'Dancing Script', cursive; font-size: 3rem; color: var(--gold); display: block; margin-bottom: 0.3rem; }
        footer .sub { font-size: 0.78rem; letter-spacing: 4px; text-transform: uppercase; }
        footer .hearts { font-size: 1.2rem; margin-top: 1rem; display: block; opacity: .6; }

        /* ── SCROLL REVEAL ── */
        .reveal {
            opacity: 0;
            transform: translateY(55px);
            transition: opacity 0.85s cubic-bezier(0.22,1,0.36,1),
                        transform 0.85s cubic-bezier(0.22,1,0.36,1);
        }
        .reveal.from-left  { transform: translateX(-55px); }
        .reveal.from-right { transform: translateX(55px);  }
        .reveal.scale-in   { transform: scale(0.88);       }
        .reveal.visible    { opacity: 1; transform: none !important; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .gallery-masonry { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 180px; }
            .g-item:nth-child(8) { grid-column: span 1; }
            .tl-wrap::before { left: 20px; }
            .tl-item, .tl-item:nth-child(even) { flex-direction: column; padding-left: 50px; }
            .tl-card { width: 100%; }
            .tl-dot { left: 20px; }
        }
        @media (max-width: 480px) {
            .gallery-masonry { grid-template-columns: 1fr; grid-auto-rows: 220px; }
            .g-item:nth-child(1), .g-item:nth-child(5) { grid-row: span 1; }
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
<div id="lightbox">
    <button id="lightbox-close" aria-label="Cerrar">✕</button>
    <img id="lightbox-img" src="" alt="Foto ampliada">
</div>

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
    <p class="cd-label reveal">✨ ¡Faltan solo...</p>
    <div class="cd-grid reveal">
        <div class="cd-item"><span class="cd-num" id="cd-days">--</span><span class="cd-unit">Días</span></div>
        <div class="cd-item"><span class="cd-num" id="cd-hours">--</span><span class="cd-unit">Horas</span></div>
        <div class="cd-item"><span class="cd-num" id="cd-mins">--</span><span class="cd-unit">Minutos</span></div>
        <div class="cd-item"><span class="cd-num" id="cd-secs">--</span><span class="cd-unit">Segundos</span></div>
    </div>
    <p class="cd-footer reveal">...para mi gran noche! 🌟</p>
</div>

{{-- ── MENSAJE PERSONAL ── --}}
<section id="message">
    <div class="section-header reveal">
        <span class="section-label">Una palabra de {{ $event->name }}</span>
        <h2 class="section-heading">Con todo mi corazón</h2>
        <div class="gold-bar"></div>
    </div>
    <div class="msg-quote reveal">
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

{{-- ── DETALLES ── --}}
<section id="details">
    <div class="section-header reveal">
        <span class="section-label">El Gran Evento</span>
        <h2 class="section-heading">Detalles de la Celebración</h2>
        <div class="gold-bar"></div>
    </div>
    <div class="details-grid">
        <div class="detail-card reveal">
            <span class="detail-icon">📅</span>
            <h3>Fecha</h3>
            <p class="detail-hl">{{ ucfirst($event->event_date->translatedFormat('l, d \d\e F')) }}</p>
            <p>{{ $event->event_date->format('Y') }}</p>
        </div>
        <div class="detail-card reveal">
            <span class="detail-icon">🕖</span>
            <h3>Hora</h3>
            @if($event->event_time)
                <p class="detail-hl">{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                <p>Llegada de invitados</p>
            @else
                <p class="detail-hl">7:00 PM</p>
                <p>Llegada de invitados<br>8:00 PM Ceremonia</p>
            @endif
        </div>
        <div class="detail-card reveal">
            <span class="detail-icon">🏛️</span>
            <h3>Lugar</h3>
            @if($event->venue_name)
                <p class="detail-hl">{{ $event->venue_name }}</p>
            @else
                <p class="detail-hl">Salón "La Perla"</p>
            @endif
            @if($event->venue_address)
                <p>{{ $event->venue_address }}</p>
            @else
                <p>Av. Principal #123<br>Centro, Ciudad</p>
            @endif
        </div>
        <div class="detail-card reveal">
            <span class="detail-icon">👗</span>
            <h3>Dress Code</h3>
            @if($event->dress_code)
                <div class="dc-pill">{{ $event->dress_code }}</div>
            @else
                <p>Formal Elegante</p>
                <div class="dc-pill">Evitar rosa y blanco</div>
            @endif
        </div>
    </div>
</section>

{{-- ── GALERÍA DE RECUERDOS ── --}}
@php
    $galleryPhotos = $event->photos->skip(1)->take(9);
    $dummySeeds    = ['xv11','xv22','xv33','xv44','xv55','xv66','xv77','xv88','xv99'];
    $dummySizes    = ['600/900','600/400','600/400','600/400','600/900','600/400','600/400','600/400','1200/400'];
    $needed        = max(0, 9 - $galleryPhotos->count());
@endphp
<section id="gallery">
    <div class="section-header reveal">
        <span class="section-label">Momentos especiales</span>
        <h2 class="section-heading">Galería de Recuerdos</h2>
        <div class="gold-bar"></div>
    </div>
    <div class="gallery-masonry">
        @foreach($galleryPhotos as $photo)
            <div class="g-item reveal">
                <img src="{{ $photo->url }}" alt="" loading="lazy">
            </div>
        @endforeach
        @for($i = 0; $i < $needed; $i++)
            <div class="g-item reveal">
                <img src="https://picsum.photos/seed/{{ $dummySeeds[$galleryPhotos->count() + $i] }}/{{ $dummySizes[$galleryPhotos->count() + $i] }}" alt="" loading="lazy">
            </div>
        @endfor
    </div>
</section>

{{-- ── RECUERDOS FAVORITOS (carousel) ── --}}
@php
    $carouselPhotos = $event->photos->skip(1)->take(5)->values();
    $carouselDummy  = [
        ['seed' => 'xvc1', 'caption' => 'Mi infancia llena de sueños ✨'],
        ['seed' => 'xvc2', 'caption' => 'Momentos con mi familia 💕'],
        ['seed' => 'xvc3', 'caption' => 'Las mejores amigas del mundo 🌸'],
        ['seed' => 'xvc4', 'caption' => 'Creciendo con amor 🌺'],
        ['seed' => 'xvc5', 'caption' => 'Hacia una nueva etapa 🦋'],
    ];
    $carouselCaptions = [
        'Mi infancia llena de sueños ✨',
        'Momentos con mi familia 💕',
        'Las mejores amigas del mundo 🌸',
        'Creciendo con amor 🌺',
        'Hacia una nueva etapa 🦋',
    ];
@endphp
<section id="carousel-section">
    <div class="section-header reveal">
        <span class="section-label">Mi historia en fotos</span>
        <h2 class="section-heading">Recuerdos Favoritos</h2>
        <div class="gold-bar"></div>
    </div>

    <div class="c-wrap reveal scale-in" id="carouselWrap">
        <div class="c-track" id="carouselTrack">
            @if($carouselPhotos->count() > 0)
                @foreach($carouselPhotos as $i => $photo)
                    <div class="c-slide">
                        <img src="{{ $photo->url }}" alt="" loading="lazy">
                        <div class="c-caption">
                            <span>{{ $carouselCaptions[$i] ?? '✨' }}</span>
                        </div>
                    </div>
                @endforeach
                @for($i = $carouselPhotos->count(); $i < 5; $i++)
                    <div class="c-slide">
                        <img src="https://picsum.photos/seed/{{ $carouselDummy[$i]['seed'] }}/820/615" alt="" loading="lazy">
                        <div class="c-caption"><span>{{ $carouselDummy[$i]['caption'] }}</span></div>
                    </div>
                @endfor
            @else
                @foreach($carouselDummy as $slide)
                    <div class="c-slide">
                        <img src="https://picsum.photos/seed/{{ $slide['seed'] }}/820/615" alt="" loading="lazy">
                        <div class="c-caption"><span>{{ $slide['caption'] }}</span></div>
                    </div>
                @endforeach
            @endif
        </div>
        <button class="c-btn prev" id="c-prev" aria-label="Anterior">&#8592;</button>
        <button class="c-btn next" id="c-next" aria-label="Siguiente">&#8594;</button>
    </div>

    <div class="c-dots" id="c-dots"></div>
</section>

{{-- ── PROGRAMA DEL EVENTO ── --}}
<section id="timeline">
    <div class="section-header reveal">
        <span class="section-label">La noche perfecta</span>
        <h2 class="section-heading">Programa del Evento</h2>
        <div class="gold-bar"></div>
    </div>

    <div class="tl-wrap">
        <div class="tl-item reveal from-right">
            <div class="tl-dot"></div>
            <div class="tl-card">
                <p class="tl-time">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('g:i A') : '6:00 PM' }}</p>
                <h4>🌸 Recepción de Invitados</h4>
                <p>Bienvenida con cóctel de bienvenida y música de ambiente.</p>
            </div>
        </div>
        <div class="tl-item reveal from-left">
            <div class="tl-dot"></div>
            <div class="tl-card">
                <p class="tl-time">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->addHour()->format('g:i A') : '7:00 PM' }}</p>
                <h4>👑 Entrada de la Quinceañera</h4>
                <p>El gran momento: {{ $event->name }} hace su entrada triunfal.</p>
            </div>
        </div>
        <div class="tl-item reveal from-right">
            <div class="tl-dot"></div>
            <div class="tl-card">
                <p class="tl-time">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->addMinutes(90)->format('g:i A') : '7:30 PM' }}</p>
                <h4>💃 El Vals</h4>
                <p>Baile del vals con chambelanes. ¡El momento más esperado!</p>
            </div>
        </div>
        <div class="tl-item reveal from-left">
            <div class="tl-dot"></div>
            <div class="tl-card">
                <p class="tl-time">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->addHours(2)->format('g:i A') : '8:00 PM' }}</p>
                <h4>🎂 Brindis y Pastel</h4>
                <p>Palabras de los padres, brindis y corte del pastel de XV.</p>
            </div>
        </div>
        <div class="tl-item reveal from-right">
            <div class="tl-dot"></div>
            <div class="tl-card">
                <p class="tl-time">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->addMinutes(150)->format('g:i A') : '8:30 PM' }}</p>
                <h4>🎉 ¡A Bailar!</h4>
                <p>Pista de baile abierta, cena y la fiesta que todos esperamos.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── UBICACIÓN ── --}}
<section id="location">
    <div class="section-header reveal">
        <span class="section-label">¿Cómo llegar?</span>
        <h2 class="section-heading">Ubicación del Evento</h2>
        <div class="gold-bar"></div>
    </div>

    <div class="loc-card reveal scale-in">
        <div class="loc-map">
            <div class="loc-pin">📍</div>
            <span class="loc-map-label">
                {{ $event->venue_name ?? 'Salón de Eventos' }}
            </span>
        </div>
        <div class="loc-body">
            <h3>{{ $event->venue_name ?? 'Salón de Eventos' }}</h3>
            <p>{{ $event->venue_address ?? 'Av. Principal #123, Col. Centro' }}</p>
            <div class="loc-chips">
                <span class="loc-chip">🚗 Estacionamiento gratuito</span>
                <span class="loc-chip">♿ Acceso universal</span>
            </div>
            @if($event->venue_maps_url)
                <a href="{{ $event->venue_maps_url }}" target="_blank" rel="noopener" class="map-btn">
                    📍 Ver en Google Maps
                </a>
            @endif
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer>
    <span class="footer-name">{{ $event->name }}</span>
    <p class="sub">XV Años &nbsp;·&nbsp; {{ ucfirst($event->event_date->translatedFormat('d \d\e F Y')) }}</p>
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
    const cdGrid = document.getElementById('countdown');

    function tick() {
        const diff = eventDate - Date.now();
        if (diff <= 0) {
            cdGrid.querySelector('.cd-grid').innerHTML =
                '<p style="font-family:\'Dancing Script\',cursive;font-size:1.8rem;color:var(--gold);">¡Hoy es el gran día! 🎉</p>';
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
(function () {
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
})();

// ── SCROLL REVEAL ──
(function () {
    const GRID_PARENTS = ['details-grid', 'gallery-masonry', 'cd-grid', 'tl-wrap'];

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const el        = entry.target;
            const parent    = el.parentElement;
            const isGrid    = GRID_PARENTS.some(cls => parent.classList.contains(cls));
            const siblings  = isGrid ? Array.from(parent.querySelectorAll('.reveal')) : [];
            const idx       = isGrid ? siblings.indexOf(el) : 0;
            const delay     = isGrid ? idx * 110 : 0;

            setTimeout(() => el.classList.add('visible'), delay);
            observer.unobserve(el);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
})();

// ── CAROUSEL ──
(function () {
    const track  = document.getElementById('carouselTrack');
    const slides = track.querySelectorAll('.c-slide');
    const dotsEl = document.getElementById('c-dots');
    let current  = 0;
    let timer;

    slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.className = 'c-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', () => { goTo(i); resetTimer(); });
        dotsEl.appendChild(dot);
    });

    function goTo(n) {
        current = ((n % slides.length) + slides.length) % slides.length;
        track.style.transform = `translateX(-${current * 100}%)`;
        dotsEl.querySelectorAll('.c-dot').forEach((d, i) => d.classList.toggle('active', i === current));
    }

    document.getElementById('c-prev').addEventListener('click', () => { goTo(current - 1); resetTimer(); });
    document.getElementById('c-next').addEventListener('click', () => { goTo(current + 1); resetTimer(); });

    // Touch swipe
    let touchX = 0;
    track.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
        const dx = touchX - e.changedTouches[0].clientX;
        if (Math.abs(dx) > 45) { goTo(current + (dx > 0 ? 1 : -1)); resetTimer(); }
    });

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(current + 1), 4500);
    }

    const wrap = document.getElementById('carouselWrap');
    wrap.addEventListener('mouseenter', () => clearInterval(timer));
    wrap.addEventListener('mouseleave', resetTimer);

    resetTimer();
})();
</script>

</body>
</html>
