<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $event->name }} · XV Años</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Cormorant+Garamond:ital,wght@0,400;0,500;1,400;1,500&family=Jost:wght@300;400;500&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Base ── */
        :root {
            --cream:      #F4E8D5;
            --cream-2:    #EADBC1;
            --paper:      #F9F1E1;
            --terra:      #B25A36;
            --terra-deep: #6F2E1B;
            --terra-soft: #D89274;
            --olive:      #6E7A55;
            --ink:        #3A2718;
            --ink-soft:   #7A6451;
            --hair:       rgba(58,39,24,0.18);

            --display: "Italiana", "Cormorant Garamond", serif;
            --serif:   "Cormorant Garamond", serif;
            --sans:    "Jost", "Helvetica Neue", sans-serif;
            --mono:    "JetBrains Mono", ui-monospace, monospace;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            background: var(--cream);
            color: var(--ink);
            font-family: var(--serif);
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
        body { min-height: 100vh; overflow-x: hidden; }
        img  { display: block; max-width: 100%; }

        /* ── Envelope overlay ── */
        #envelope-stage {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: grid;
            place-items: center;
            background: radial-gradient(ellipse at 50% 30%, #efe0c5 0%, #d6bf9b 70%, #b89970 100%);
            perspective: 1800px;
            cursor: pointer;
            transition: opacity 0.8s ease 1.2s, visibility 0.8s ease 1.2s;
            user-select: none;
        }
        #envelope-stage.open {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .envelope {
            position: relative;
            width: min(420px, 80vw);
            aspect-ratio: 3 / 2;
            transform-style: preserve-3d;
            transition: transform 1.2s cubic-bezier(.6,.05,.3,1);
        }
        #envelope-stage.open .envelope {
            transform: translateY(-40vh) scale(0.4) rotate(-2deg);
            opacity: 0;
            transition: transform 1.4s cubic-bezier(.5,.05,.3,1) 0.7s, opacity 0.6s ease 1.6s;
        }
        .env-body {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, #e7d3b1, #d4b88c);
            border-radius: 4px;
            box-shadow:
                0 30px 60px -20px rgba(70,38,18,.45),
                0 6px 14px -4px rgba(70,38,18,.25),
                inset 0 0 0 1px rgba(255,255,255,.18);
            overflow: hidden;
        }
        .env-body::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, transparent calc(50% - 0.5px), rgba(58,39,24,.18) 50%, transparent calc(50% + 0.5px)) no-repeat,
                linear-gradient(45deg,  transparent calc(50% - 0.5px), rgba(58,39,24,.18) 50%, transparent calc(50% + 0.5px)) no-repeat;
            background-size: 100% 100%, 100% 100%;
            background-position: 0 100%, 100% 100%;
        }
        .env-letter {
            position: absolute;
            left: 8%; right: 8%; top: 18%; bottom: 14%;
            background: var(--paper);
            border-radius: 2px;
            box-shadow: 0 6px 18px rgba(0,0,0,.15);
            transform-origin: center bottom;
            transform: translateY(0) scale(0.96);
            transition: transform 1s cubic-bezier(.5,0,.3,1) 0.3s;
            display: grid;
            place-items: center;
            padding: 18px;
            text-align: center;
        }
        #envelope-stage.open .env-letter {
            transform: translateY(-12%) scale(1);
        }
        .env-letter-inner {
            font-family: var(--display);
            font-size: clamp(14px, 2.6vw, 22px);
            letter-spacing: 0.32em;
            color: var(--terra-deep);
            text-transform: uppercase;
        }
        .env-letter-inner .nombre {
            display: block;
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(36px, 7vw, 60px);
            letter-spacing: 0;
            text-transform: none;
            color: var(--terra);
            margin: 0.25em 0;
            line-height: 1;
        }
        .env-letter-inner .dash {
            display: block;
            width: 28px; height: 1px;
            background: var(--terra);
            margin: 12px auto;
        }
        .env-flap {
            position: absolute;
            left: 0; right: 0; top: 0;
            height: 60%;
            background: linear-gradient(180deg, #cba679, #b08a5c);
            clip-path: polygon(0 0, 100% 0, 50% 100%);
            transform-origin: top center;
            transform: rotateX(0deg);
            transition: transform 1.1s cubic-bezier(.5,0,.3,1);
            z-index: 3;
            box-shadow: inset 0 2px 0 rgba(255,255,255,.18);
        }
        #envelope-stage.open .env-flap { transform: rotateX(-180deg); }

        .env-seal {
            position: absolute;
            left: 50%; top: 56%;
            width: 56px; height: 56px;
            transform: translate(-50%,-50%);
            background: radial-gradient(circle at 35% 35%, #c4724c, var(--terra-deep) 70%);
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,.25), inset 0 -3px 6px rgba(0,0,0,.25);
            z-index: 4;
            display: grid;
            place-items: center;
            color: #f4e8d5;
            font-family: var(--display);
            font-size: 22px;
            letter-spacing: 0.06em;
            transition: transform 0.6s ease, opacity 0.4s ease;
        }
        #envelope-stage.open .env-seal {
            transform: translate(-50%,-50%) scale(0.6) rotate(60deg);
            opacity: 0;
        }
        .env-instructions {
            position: absolute;
            bottom: 8vh; left: 0; right: 0;
            text-align: center;
            font-family: var(--sans);
            letter-spacing: 0.4em;
            font-size: 11px;
            color: var(--terra-deep);
            text-transform: uppercase;
            opacity: 0.75;
            animation: envPulse 2.4s ease-in-out infinite;
        }
        @keyframes envPulse {
            0%, 100% { opacity: 0.4; transform: translateY(0); }
            50%       { opacity: 0.85; transform: translateY(-2px); }
        }
        #envelope-stage.open .env-instructions { opacity: 0; }

        /* ── Main content (fades in after envelope) ── */
        #main-content {
            opacity: 0;
            transition: opacity 0.6s ease;
        }
        #main-content.visible { opacity: 1; }

        /* ── Sections ── */
        section {
            position: relative;
            padding: clamp(72px, 12vw, 140px) clamp(24px, 6vw, 80px);
        }

        .eyebrow {
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.42em;
            text-transform: uppercase;
            color: var(--terra-deep);
            font-weight: 400;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            justify-content: center;
            color: var(--terra);
            margin: 22px auto;
        }
        .divider::before, .divider::after {
            content: "";
            display: block;
            height: 1px;
            width: clamp(40px, 8vw, 90px);
            background: currentColor;
            opacity: 0.6;
        }

        /* ── Branch ornament ── */
        .branch {
            position: absolute;
            color: var(--terra);
            opacity: 0.55;
            pointer-events: none;
        }
        .branch.tl { top: 30px;    left: 30px;  transform: rotate(-10deg);  }
        .branch.tr { top: 30px;    right: 30px; transform: rotate(190deg);  }
        .branch.bl { bottom: 30px; left: 30px;  transform: rotate(170deg);  }
        .branch.br { bottom: 30px; right: 30px; transform: rotate(10deg);   }
        @media (max-width: 640px) {
            .branch { width: 80px !important; height: auto; }
        }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            display: grid;
            place-items: center;
            text-align: center;
            padding: clamp(60px,10vw,120px) clamp(24px,6vw,80px);
            background:
                radial-gradient(ellipse at 50% 0%, rgba(178,90,54,.08), transparent 60%),
                var(--cream);
        }
        .hero-inner { max-width: 760px; margin: 0 auto; }

        .hero-photo {
            width: clamp(220px, 36vw, 340px);
            aspect-ratio: 3 / 4;
            margin: 0 auto 36px;
            border-radius: 999px 999px 8px 8px;
            background:
                repeating-linear-gradient(45deg, rgba(178,90,54,.12) 0 8px, transparent 8px 16px),
                linear-gradient(180deg, #e7d3b1, #c89c70);
            border: 1px solid rgba(58,39,24,.2);
            display: grid;
            place-items: end center;
            padding: 18px;
            color: var(--terra-deep);
            font-family: var(--mono);
            font-size: 11px;
            letter-spacing: 0.18em;
            overflow: hidden;
        }
        .hero-photo span {
            background: var(--paper);
            padding: 4px 10px;
            border: 1px solid currentColor;
            border-radius: 999px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }
        .hero-photo img {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .hero-photo { position: relative; }

        .hero h1 {
            font-family: var(--display);
            font-size: clamp(72px, 16vw, 200px);
            font-weight: 400;
            line-height: 0.9;
            color: var(--terra);
            letter-spacing: -0.01em;
        }
        .hero h1 em {
            font-family: var(--serif);
            font-style: italic;
            font-weight: 400;
            display: block;
        }
        .hero .date-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 28px;
            margin-top: 36px;
            font-family: var(--sans);
            font-size: 13px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--ink);
        }
        .hero .date-row .num {
            font-family: var(--display);
            font-size: clamp(36px, 5vw, 56px);
            letter-spacing: 0;
            color: var(--terra-deep);
            line-height: 1;
        }
        .hero .subtitle {
            margin-top: 14px;
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(18px, 2.2vw, 24px);
            color: var(--ink-soft);
        }
        .scroll-hint {
            position: absolute;
            bottom: 28px; left: 50%;
            transform: translateX(-50%);
            font-family: var(--sans);
            font-size: 10px;
            letter-spacing: 0.5em;
            color: var(--terra-deep);
            text-transform: uppercase;
        }
        .scroll-hint::after {
            content: "";
            display: block;
            width: 1px; height: 32px;
            background: var(--terra-deep);
            margin: 10px auto 0;
            animation: scrollline 1.8s ease-in-out infinite;
        }
        @keyframes scrollline {
            0%   { transform: scaleY(0.2); transform-origin: top; }
            50%  { transform: scaleY(1); }
            100% { transform: scaleY(0.2); transform-origin: bottom; }
        }

        /* ── Verse ── */
        .verse {
            text-align: center;
            background: var(--cream-2);
            padding-block: clamp(80px, 14vw, 160px);
        }
        .verse blockquote {
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(22px, 3.4vw, 38px);
            line-height: 1.4;
            max-width: 720px;
            margin: 0 auto;
            color: var(--ink);
            text-wrap: pretty;
        }
        .verse cite {
            display: block;
            margin-top: 28px;
            font-style: normal;
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--terra-deep);
        }

        /* ── Countdown ── */
        .countdown { text-align: center; background: var(--cream); }
        .countdown h2 {
            font-family: var(--display);
            font-size: clamp(44px, 7vw, 80px);
            font-weight: 400;
            color: var(--terra-deep);
            letter-spacing: 0.02em;
        }
        .countdown h2 em { font-family: var(--serif); font-style: italic; color: var(--terra); }
        .countdown-grid {
            margin-top: 56px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: clamp(12px, 3vw, 36px);
            max-width: 880px;
            margin-inline: auto;
        }
        .cd-cell {
            aspect-ratio: 1;
            border: 1px solid var(--hair);
            background: var(--paper);
            display: grid;
            place-items: center;
            position: relative;
            border-radius: 6px;
        }
        .cd-cell::before {
            content: "";
            position: absolute;
            inset: 8px;
            border: 1px solid rgba(178,90,54,.25);
            border-radius: 4px;
            pointer-events: none;
        }
        .cd-num {
            font-family: var(--display);
            font-size: clamp(40px, 8vw, 84px);
            color: var(--terra);
            line-height: 1;
        }
        .cd-label {
            position: absolute;
            bottom: 14%;
            font-family: var(--sans);
            font-size: 10px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        @media (max-width: 640px) {
            .countdown-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* ── Itinerary ── */
        .itinerary { background: var(--paper); padding-block: clamp(80px, 14vw, 160px); }
        .itinerary .head { text-align: center; margin-bottom: 72px; }
        .itinerary h2 {
            font-family: var(--display);
            font-size: clamp(48px, 8vw, 96px);
            color: var(--terra-deep);
            font-weight: 400;
        }
        .timeline {
            max-width: 720px;
            margin: 0 auto;
            position: relative;
        }
        .timeline::before {
            content: "";
            position: absolute;
            left: 80px; top: 0; bottom: 0;
            width: 1px;
            background: var(--hair);
        }
        .event-row {
            display: grid;
            grid-template-columns: 80px 40px 1fr;
            align-items: start;
            gap: 24px;
            padding: 28px 0;
            position: relative;
        }
        .event-time {
            font-family: var(--display);
            font-size: clamp(24px, 3vw, 32px);
            color: var(--terra);
            text-align: right;
            line-height: 1;
            padding-top: 4px;
        }
        .event-dot {
            width: 14px; height: 14px;
            border-radius: 50%;
            background: var(--cream);
            border: 1px solid var(--terra);
            margin-left: 13px; margin-top: 8px;
            position: relative; z-index: 1;
        }
        .event-dot::after {
            content: "";
            position: absolute;
            inset: 3px;
            border-radius: 50%;
            background: var(--terra);
        }
        .event-title {
            font-family: var(--display);
            font-size: clamp(22px, 3vw, 30px);
            color: var(--ink);
            letter-spacing: 0.01em;
        }
        .event-desc {
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(15px, 1.6vw, 17px);
            color: var(--ink-soft);
            margin-top: 6px;
            line-height: 1.5;
        }
        @media (max-width: 540px) {
            .timeline::before { left: 56px; }
            .event-row { grid-template-columns: 56px 32px 1fr; gap: 14px; }
            .event-dot { margin-left: 9px; }
        }

        /* ── Gallery ── */
        .gallery { background: var(--cream); text-align: center; }
        .gallery .head { margin-bottom: 56px; }
        .gallery h2 {
            font-family: var(--display);
            font-size: clamp(48px, 8vw, 96px);
            color: var(--terra-deep);
            font-weight: 400;
        }
        .gallery h2 em { font-family: var(--serif); font-style: italic; color: var(--terra); }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .gal-photo {
            background:
                repeating-linear-gradient(45deg, rgba(178,90,54,.12) 0 8px, transparent 8px 16px),
                linear-gradient(180deg, #e7d3b1, #c89c70);
            border: 1px solid rgba(58,39,24,.18);
            display: grid;
            place-items: center;
            color: var(--terra-deep);
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }
        .gal-photo img {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .gal-photo span {
            background: var(--paper);
            border: 1px solid currentColor;
            padding: 3px 9px;
            border-radius: 999px;
            position: relative;
            z-index: 1;
        }
        .gal-photo.tall { grid-column: span 2; grid-row: span 2; aspect-ratio: 3/4; }
        .gal-photo.wide { grid-column: span 4; aspect-ratio: 16/9; }
        .gal-photo.sq   { grid-column: span 2; aspect-ratio: 1;   }
        .gal-photo.mid  { grid-column: span 3; aspect-ratio: 4/5; }
        @media (max-width: 720px) {
            .gallery-grid { grid-template-columns: repeat(2, 1fr); }
            .gal-photo.tall, .gal-photo.wide, .gal-photo.sq, .gal-photo.mid {
                grid-column: span 1; grid-row: span 1; aspect-ratio: 3/4;
            }
        }

        /* ── Location ── */
        .location {
            background: var(--terra-deep);
            color: var(--cream);
            text-align: center;
            padding-block: clamp(100px, 16vw, 180px);
        }
        .location .eyebrow { color: var(--terra-soft); }
        .location h2 {
            font-family: var(--display);
            font-size: clamp(48px, 8vw, 110px);
            font-weight: 400;
            color: var(--cream);
            margin-top: 12px;
            line-height: 1;
        }
        .location h2 em { font-family: var(--serif); font-style: italic; color: var(--terra-soft); }
        .location .address {
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(18px, 2.2vw, 22px);
            margin-top: 22px;
            color: rgba(244,232,213,.85);
        }
        .map-card {
            margin: 60px auto 0;
            max-width: 760px;
            aspect-ratio: 16/10;
            background: var(--paper);
            border-radius: 6px;
            position: relative;
            overflow: hidden;
            color: var(--terra-deep);
            border: 1px solid rgba(244,232,213,.25);
        }
        .map-stylized {
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 30% 50%, rgba(110,122,85,.18), transparent 40%),
                radial-gradient(circle at 70% 60%, rgba(178,90,54,.12), transparent 35%),
                linear-gradient(180deg, #f1e2c7, #e3cda6);
        }
        .map-stylized svg { position: absolute; inset: 0; width: 100%; height: 100%; }
        .map-pin {
            position: absolute;
            left: 50%; top: 50%;
            transform: translate(-50%, -100%);
            display: grid;
            place-items: center;
            font-family: var(--sans);
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--terra-deep);
        }
        .map-pin .dot {
            width: 18px; height: 18px;
            border-radius: 50%;
            background: var(--terra);
            box-shadow: 0 0 0 5px rgba(178,90,54,.25), 0 0 0 12px rgba(178,90,54,.1);
            margin-bottom: 8px;
            animation: ping 2.4s ease-out infinite;
        }
        @keyframes ping {
            0%   { box-shadow: 0 0 0 0 rgba(178,90,54,.5), 0 0 0 0 rgba(178,90,54,.3); }
            100% { box-shadow: 0 0 0 14px rgba(178,90,54,0), 0 0 0 28px rgba(178,90,54,0); }
        }
        .btn-link {
            margin-top: 36px;
            display: inline-block;
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            color: var(--cream);
            padding: 16px 32px;
            border: 1px solid var(--terra-soft);
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .btn-link:hover { background: var(--cream); color: var(--terra-deep); }

        /* ── Dress code ── */
        .dresscode {
            background: var(--cream-2);
            text-align: center;
            padding-block: clamp(100px, 14vw, 160px);
        }
        .dresscode h2 {
            font-family: var(--display);
            font-size: clamp(48px, 8vw, 96px);
            color: var(--terra-deep);
            font-weight: 400;
            line-height: 1;
        }
        .dresscode h2 em { font-family: var(--serif); font-style: italic; color: var(--terra); }
        .dc-grid {
            margin-top: 56px;
            display: grid;
            grid-template-columns: 1fr 1px 1fr;
            gap: clamp(20px, 4vw, 60px);
            max-width: 720px;
            margin-inline: auto;
        }
        .dc-grid .sep { background: var(--hair); width: 1px; }
        .dc-col { padding: 8px 0; }
        .dc-col .ico { width: 64px; height: 64px; margin: 0 auto 18px; color: var(--terra); }
        .dc-col h3 {
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            color: var(--terra-deep);
            font-weight: 500;
        }
        .dc-col p {
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(17px, 2vw, 20px);
            color: var(--ink);
            margin-top: 14px;
            line-height: 1.5;
        }
        .dc-palette { margin-top: 56px; display: flex; flex-direction: column; align-items: center; gap: 16px; }
        .dc-palette .label {
            font-family: var(--sans);
            font-size: 10px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--ink-soft);
        }
        .dc-swatches { display: flex; gap: 14px; align-items: center; }
        .dc-sw {
            width: 32px; height: 32px;
            border-radius: 50%;
            box-shadow: 0 0 0 1px var(--hair);
            position: relative;
        }
        .dc-sw.x::after {
            content: "";
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            border: 1px solid var(--terra-deep);
            background: linear-gradient(45deg, transparent calc(50% - 0.5px), var(--terra-deep) 50%, transparent calc(50% + 0.5px));
        }
        @media (max-width: 540px) {
            .dc-grid { grid-template-columns: 1fr; }
            .dc-grid .sep { height: 1px; width: 60px; margin: 0 auto; }
        }

        /* ── Gifts ── */
        .gifts {
            background: var(--paper);
            text-align: center;
            padding-block: clamp(100px, 14vw, 160px);
        }
        .gifts h2 {
            font-family: var(--display);
            font-size: clamp(36px, 5.5vw, 64px);
            color: var(--terra-deep);
            font-weight: 400;
            line-height: 1.15;
            max-width: 720px;
            margin: 22px auto 0;
        }
        .gifts h2 em { font-family: var(--serif); font-style: italic; color: var(--terra); }
        .gifts .note {
            margin: 20px auto 0;
            max-width: 540px;
            font-family: var(--serif);
            font-style: italic;
            font-size: clamp(16px, 1.8vw, 18px);
            color: var(--ink-soft);
        }
        .gift-grid {
            margin-top: 60px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            max-width: 920px;
            margin-inline: auto;
        }
        .gift-card {
            background: var(--cream);
            border: 1px solid var(--hair);
            border-radius: 6px;
            padding: 36px 24px 28px;
            text-align: center;
            text-decoration: none;
            color: var(--ink);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .gift-card:hover { transform: translateY(-3px); background: var(--paper); }
        .gift-card .brand { font-family: var(--display); font-size: 26px; color: var(--terra); letter-spacing: 0.02em; line-height: 1; }
        .gift-card .meta { font-family: var(--sans); font-size: 10px; letter-spacing: 0.4em; text-transform: uppercase; color: var(--ink-soft); }
        .gift-card .code { margin-top: 8px; font-family: var(--mono); font-size: 12px; color: var(--terra-deep); padding: 6px 12px; border: 1px dashed var(--hair); border-radius: 3px; background: var(--paper); }
        .gift-card .arrow { margin-top: 6px; font-family: var(--sans); font-size: 11px; letter-spacing: 0.4em; text-transform: uppercase; color: var(--terra-deep); }
        @media (max-width: 720px) { .gift-grid { grid-template-columns: 1fr; max-width: 360px; } }

        /* ── RSVP ── */
        .rsvp { background: var(--cream); text-align: center; padding-block: clamp(100px, 14vw, 160px); }
        .rsvp h2 { font-family: var(--display); font-size: clamp(44px, 7vw, 80px); color: var(--terra-deep); font-weight: 400; line-height: 1; }
        .rsvp h2 em { font-family: var(--serif); font-style: italic; color: var(--terra); }
        .rsvp .deadline { margin-top: 18px; font-family: var(--serif); font-style: italic; font-size: clamp(17px, 2vw, 20px); color: var(--ink-soft); }
        .rsvp form { margin: 60px auto 0; max-width: 480px; display: flex; flex-direction: column; gap: 22px; text-align: left; }
        .field { display: flex; flex-direction: column; gap: 8px; }
        .field label { font-family: var(--sans); font-size: 10px; letter-spacing: 0.4em; text-transform: uppercase; color: var(--terra-deep); font-weight: 500; }
        .field input, .field textarea {
            background: transparent;
            border: 0;
            border-bottom: 1px solid var(--hair);
            padding: 10px 0;
            font-family: var(--serif);
            font-size: 17px;
            color: var(--ink);
            outline: none;
            transition: border-color 0.25s ease;
        }
        .field input:focus, .field textarea:focus { border-color: var(--terra); }
        .field textarea { resize: none; min-height: 80px; font-style: italic; }
        .rsvp-options { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 4px; }
        .rsvp-opt {
            appearance: none;
            background: transparent;
            border: 1px solid var(--hair);
            padding: 16px 12px;
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--ink);
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.25s ease, color 0.25s ease, border-color 0.25s ease;
        }
        .rsvp-opt:hover { border-color: var(--terra); }
        .rsvp-opt.selected { background: var(--terra); border-color: var(--terra); color: var(--cream); }
        .guests-row { display: flex; align-items: center; gap: 16px; }
        .guests-row button {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid var(--hair);
            background: transparent;
            font-family: var(--display);
            font-size: 22px;
            color: var(--terra);
            cursor: pointer;
            transition: background 0.2s ease;
            line-height: 1;
        }
        .guests-row button:hover { background: var(--paper); }
        .guests-row button:disabled { opacity: 0.3; cursor: not-allowed; }
        .guests-row .count { font-family: var(--display); font-size: 32px; color: var(--terra-deep); min-width: 40px; text-align: center; line-height: 1; }
        .guests-field { display: none; }
        .rsvp-submit {
            margin-top: 16px;
            appearance: none;
            background: var(--terra-deep);
            color: var(--cream);
            border: 0;
            padding: 18px 28px;
            font-family: var(--sans);
            font-size: 11px;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 3px;
            transition: background 0.25s ease;
        }
        .rsvp-submit:hover { background: var(--terra); }
        .rsvp-submit:disabled { opacity: 0.4; cursor: not-allowed; }
        .rsvp-thanks {
            display: none;
            margin: 60px auto 0;
            max-width: 540px;
            text-align: center;
            padding: 56px 36px;
            background: var(--paper);
            border: 1px solid var(--hair);
            border-radius: 6px;
        }
        .rsvp-thanks .icon {
            width: 44px; height: 44px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: var(--terra);
            color: var(--cream);
            display: grid;
            place-items: center;
            font-family: var(--display);
            font-size: 22px;
        }
        .rsvp-thanks h3 { font-family: var(--display); font-size: clamp(28px,4vw,40px); color: var(--terra-deep); font-weight: 400; }
        .rsvp-thanks p { margin-top: 14px; font-family: var(--serif); font-style: italic; font-size: clamp(15px,1.8vw,17px); color: var(--ink-soft); line-height: 1.5; }

        /* ── Closing ── */
        .closing { background: var(--cream); text-align: center; padding-block: clamp(100px, 14vw, 160px); }
        .closing h2 { font-family: var(--display); font-size: clamp(40px,6vw,72px); color: var(--terra); font-weight: 400; }
        .closing h2 em { font-family: var(--serif); font-style: italic; color: var(--terra-deep); }
        .stamp {
            margin: 40px auto 0;
            width: 120px; height: 120px;
            border-radius: 50%;
            border: 1px solid var(--hair);
            display: grid;
            place-items: center;
            font-family: var(--sans);
            font-size: 10px;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--terra-deep);
            background: var(--paper);
            position: relative;
        }
        .stamp::before { content: ""; position: absolute; inset: 6px; border: 1px solid var(--hair); border-radius: 50%; }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.9s cubic-bezier(.4,0,.2,1), transform 0.9s cubic-bezier(.4,0,.2,1);
            will-change: opacity, transform;
        }
        .reveal.in { opacity: 1; transform: none; }
        .reveal-stagger > * {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s cubic-bezier(.4,0,.2,1), transform 0.8s cubic-bezier(.4,0,.2,1);
        }
        .reveal-stagger.in > * { opacity: 1; transform: none; }
        .reveal-stagger.in > *:nth-child(1) { transition-delay: 0.05s; }
        .reveal-stagger.in > *:nth-child(2) { transition-delay: 0.15s; }
        .reveal-stagger.in > *:nth-child(3) { transition-delay: 0.25s; }
        .reveal-stagger.in > *:nth-child(4) { transition-delay: 0.35s; }
        .reveal-stagger.in > *:nth-child(5) { transition-delay: 0.45s; }
        .reveal-stagger.in > *:nth-child(6) { transition-delay: 0.55s; }
    </style>
</head>
<body>

{{-- ── ENVELOPE ── --}}
<div id="envelope-stage" role="button" tabindex="0" aria-label="Abrir invitación">
    <div class="envelope">
        <div class="env-body">
            <div class="env-letter">
                <div class="env-letter-inner">
                    <div>Tienes una invitación</div>
                    <span class="dash"></span>
                    <span class="nombre">{{ $event->name }}</span>
                    <span class="dash"></span>
                    <div>Mis XV Años</div>
                </div>
            </div>
        </div>
        <div class="env-flap"></div>
        <div class="env-seal">{{ strtoupper(substr($event->name, 0, 1)) }}</div>
    </div>
    <div class="env-instructions">Toca para abrir</div>
</div>

{{-- ── MAIN CONTENT ── --}}
<main id="main-content">

    {{-- ── HERO ── --}}
    @php
        $cover = $event->coverPhoto();
        $venueNameParts = $event->venue_name
            ? explode(' ', $event->venue_name, 2)
            : ['Rancho', 'la Herradura'];
    @endphp
    <section class="hero">
        {{-- Branch ornaments --}}
        <svg class="branch tl" width="160" height="88" viewBox="0 0 200 110" fill="none" aria-hidden="true">
            <path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/>
            <ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/>
            <ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/>
            <ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/>
            <ellipse cx="125" cy="58" rx="7" ry="2.5" fill="currentColor" transform="rotate(-2 125 58)"/>
            <ellipse cx="150" cy="52" rx="8" ry="3" fill="currentColor" transform="rotate(5 150 52)"/>
            <circle cx="35" cy="84" r="2" fill="currentColor"/>
            <circle cx="110" cy="60" r="2" fill="currentColor"/>
            <circle cx="170" cy="48" r="2.4" fill="currentColor"/>
        </svg>
        <svg class="branch tr" width="160" height="88" viewBox="0 0 200 110" fill="none" aria-hidden="true">
            <path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/>
            <ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/>
            <ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/>
            <ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/>
            <ellipse cx="125" cy="58" rx="7" ry="2.5" fill="currentColor" transform="rotate(-2 125 58)"/>
            <ellipse cx="150" cy="52" rx="8" ry="3" fill="currentColor" transform="rotate(5 150 52)"/>
            <circle cx="35" cy="84" r="2" fill="currentColor"/>
            <circle cx="110" cy="60" r="2" fill="currentColor"/>
            <circle cx="170" cy="48" r="2.4" fill="currentColor"/>
        </svg>

        <div class="hero-inner">
            <div class="eyebrow reveal">Mis XV Años</div>
            <div class="divider reveal" style="margin:20px auto 28px">
                <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
            </div>

            <div class="hero-photo reveal">
                @if($cover)
                    <img src="{{ $cover->url }}" alt="{{ $event->name }}">
                @else
                    <span>foto principal</span>
                @endif
            </div>

            <h1 class="reveal">{{ $event->name }}</h1>

            <div class="date-row reveal">
                <div>
                    <div class="num">{{ $event->event_date->format('d') }}</div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;letter-spacing:0.5em">
                    <span>{{ ucfirst($event->event_date->translatedFormat('F')) }}</span>
                    <span style="width:30px;height:1px;background:currentColor;align-self:center;opacity:.5"></span>
                    <span>{{ $event->event_date->format('Y') }}</span>
                </div>
                <div>
                    <div class="num">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('H:i') : '18:00' }}</div>
                </div>
            </div>

            @if($event->venue_name || $event->venue_address)
                <p class="subtitle reveal">
                    Una celebración inolvidable
                    {{ $event->venue_name ? 'en ' . $event->venue_name : '' }}
                    {{ $event->venue_address ? '· ' . $event->venue_address : '' }}.
                </p>
            @else
                <p class="subtitle reveal">Una celebración inolvidable bajo el cielo de Dallas.</p>
            @endif
        </div>

        <svg class="branch bl" width="140" height="77" viewBox="0 0 200 110" fill="none" aria-hidden="true">
            <path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/>
            <ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/>
            <ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/>
            <ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/>
            <ellipse cx="125" cy="58" rx="7" ry="2.5" fill="currentColor" transform="rotate(-2 125 58)"/>
            <ellipse cx="150" cy="52" rx="8" ry="3" fill="currentColor" transform="rotate(5 150 52)"/>
            <circle cx="35" cy="84" r="2" fill="currentColor"/>
            <circle cx="110" cy="60" r="2" fill="currentColor"/>
            <circle cx="170" cy="48" r="2.4" fill="currentColor"/>
        </svg>
        <svg class="branch br" width="140" height="77" viewBox="0 0 200 110" fill="none" aria-hidden="true">
            <path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/>
            <ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/>
            <ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/>
            <ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/>
            <ellipse cx="125" cy="58" rx="7" ry="2.5" fill="currentColor" transform="rotate(-2 125 58)"/>
            <ellipse cx="150" cy="52" rx="8" ry="3" fill="currentColor" transform="rotate(5 150 52)"/>
            <circle cx="35" cy="84" r="2" fill="currentColor"/>
            <circle cx="110" cy="60" r="2" fill="currentColor"/>
            <circle cx="170" cy="48" r="2.4" fill="currentColor"/>
        </svg>

        <div class="scroll-hint">Desliza</div>
    </section>

    {{-- ── VERSE ── --}}
    <section class="verse">
        <svg class="branch tl" width="120" height="66" viewBox="0 0 200 110" fill="none" aria-hidden="true"><path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/><ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/><ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/><ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/><circle cx="170" cy="48" r="2.4" fill="currentColor"/></svg>
        <svg class="branch tr" width="120" height="66" viewBox="0 0 200 110" fill="none" aria-hidden="true"><path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/><ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/><ellipse cx="72" cy="68" rx="8" ry="3" fill="currentColor" transform="rotate(-12 72 68)"/><ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/><circle cx="170" cy="48" r="2.4" fill="currentColor"/></svg>
        <blockquote class="reveal">
            "@if($event->notes){{ $event->notes }}@else Aquella niña que un día soñó con un cuento de hadas, hoy se convierte en mujer y celebra una nueva historia. @endif"
        </blockquote>
        <cite class="reveal">— Mis quince años</cite>
    </section>

    {{-- ── COUNTDOWN ── --}}
    <section class="countdown">
        <div class="eyebrow reveal">Cuenta regresiva</div>
        <h2 class="reveal" style="margin-top:18px">Faltan <em>solo</em></h2>
        <div class="divider reveal" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
        </div>
        <div class="countdown-grid reveal-stagger">
            <div class="cd-cell"><div class="cd-num" id="cd-d">--</div><div class="cd-label">Días</div></div>
            <div class="cd-cell"><div class="cd-num" id="cd-h">--</div><div class="cd-label">Horas</div></div>
            <div class="cd-cell"><div class="cd-num" id="cd-m">--</div><div class="cd-label">Minutos</div></div>
            <div class="cd-cell"><div class="cd-num" id="cd-s">--</div><div class="cd-label">Segundos</div></div>
        </div>
    </section>

    {{-- ── ITINERARY ── --}}
    @if($event->itinerary)
    <section class="itinerary">
        <div class="head">
            <div class="eyebrow reveal">El día</div>
            <h2 class="reveal" style="margin-top:18px">Itinerario</h2>
            <div class="divider reveal" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
            </div>
        </div>
        <div class="timeline reveal-stagger">
            @foreach($event->itinerary as $item)
            <div class="event-row">
                <div class="event-time">{{ $item['time'] ?? '' }}</div>
                <div class="event-dot"></div>
                <div>
                    <div class="event-title">{{ $item['title'] }}</div>
                    @if(!empty($item['description']))
                        <div class="event-desc">{{ $item['description'] }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── GALLERY ── --}}
    @php
        $galleryPhotos = $event->photos->skip(1)->take(6)->values();
        $layouts = ['tall', 'sq', 'sq', 'wide', 'mid', 'mid'];
        $dummySeeds = ['g11','g22','g33','g44','g55','g66'];
        $dummySizes = ['400/533','400/400','400/400','820/461','400/500','400/500'];
    @endphp
    <section class="gallery">
        <div class="head">
            <div class="eyebrow reveal">Galería</div>
            <h2 class="reveal" style="margin-top:18px">Recuerdos <em>en imágenes</em></h2>
            <div class="divider reveal" aria-hidden="true">
                <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
            </div>
        </div>
        <div class="gallery-grid reveal-stagger">
            @for($i = 0; $i < 6; $i++)
                @php $photo = $galleryPhotos->get($i); @endphp
                <div class="gal-photo {{ $layouts[$i] }}">
                    @if($photo)
                        <img src="{{ $photo->url }}" alt="" loading="lazy">
                    @else
                        <span>foto {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    @endif
                </div>
            @endfor
        </div>
    </section>

    {{-- ── LOCATION ── --}}
    <section class="location">
        <div class="eyebrow reveal">Ubicación</div>
        @if($event->venue_name)
            @php $parts = explode(' ', $event->venue_name, 2); @endphp
            <h2 class="reveal" style="margin-top:14px">
                {{ $parts[0] }}
                @if(isset($parts[1]))<em>{{ $parts[1] }}</em>@endif
            </h2>
        @else
            <h2 class="reveal" style="margin-top:14px">Rancho <em>la Herradura</em></h2>
        @endif
        <p class="address reveal">{{ $event->venue_address ?? 'Dallas, Texas' }}</p>
        <div class="map-card reveal">
            <div class="map-stylized">
                <svg viewBox="0 0 600 360" preserveAspectRatio="none">
                    <path d="M0 200 Q150 180 300 220 T 600 240" stroke="rgba(178,90,54,.45)" stroke-width="2" fill="none" stroke-dasharray="5 6"/>
                    <path d="M120 0 Q140 120 200 200 T 280 360" stroke="rgba(110,122,85,.4)" stroke-width="1.5" fill="none"/>
                    <path d="M450 0 Q420 150 380 240 T 360 360" stroke="rgba(110,122,85,.4)" stroke-width="1.5" fill="none"/>
                    <path d="M0 80 Q200 100 320 60 T 600 100" stroke="rgba(110,122,85,.35)" stroke-width="6" fill="none" stroke-linecap="round"/>
                    <circle cx="100" cy="290" r="40" fill="rgba(110,122,85,.15)"/>
                    <circle cx="510" cy="80"  r="56" fill="rgba(178,90,54,.12)"/>
                    <circle cx="510" cy="80"  r="34" fill="rgba(178,90,54,.16)"/>
                </svg>
                <div class="map-pin">
                    <div class="dot"></div>
                    <div>{{ $event->venue_name ?? 'Rancho la Herradura' }}</div>
                </div>
            </div>
        </div>
        <a class="btn-link reveal"
           href="{{ $event->venue_maps_url ?? 'https://maps.google.com/?q=' . urlencode(($event->venue_name ?? 'Rancho la Herradura') . ' ' . ($event->venue_address ?? 'Dallas Texas')) }}"
           target="_blank" rel="noopener">
            Cómo llegar →
        </a>
    </section>

    {{-- ── DRESS CODE ── --}}
    @if($event->dress_code)
    <section class="dresscode">
        <div class="eyebrow reveal">Código de vestimenta</div>
        <h2 class="reveal" style="margin-top:18px">{{ $event->dress_code }}</h2>
        <div class="divider reveal" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
        </div>
        @if($event->dress_code_men || $event->dress_code_women)
        <div class="dc-grid reveal-stagger">
            <div class="dc-col">
                <svg class="ico" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                    <path d="M22 8 L32 14 L42 8 L46 22 L56 26 L48 36 L52 56 L32 50 L12 56 L16 36 L8 26 L18 22 Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round" fill="none"/>
                    <path d="M32 14 L32 50" stroke="currentColor" stroke-width="1" opacity="0.5"/>
                    <circle cx="32" cy="24" r="2" fill="currentColor"/>
                    <circle cx="32" cy="32" r="2" fill="currentColor"/>
                    <circle cx="32" cy="40" r="2" fill="currentColor"/>
                </svg>
                <h3>Caballeros</h3>
                @if($event->dress_code_men)
                    <p>{{ $event->dress_code_men }}</p>
                @else
                    <p>{{ $event->dress_code }}</p>
                @endif
            </div>
            <div class="sep"></div>
            <div class="dc-col">
                <svg class="ico" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                    <path d="M26 8 H38 L40 16 C44 18 48 22 50 30 L46 32 L44 26 L46 56 H18 L20 26 L18 32 L14 30 C16 22 20 18 24 16 Z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round" fill="none"/>
                    <path d="M26 8 Q32 12 38 8" stroke="currentColor" stroke-width="1" fill="none"/>
                </svg>
                <h3>Damas</h3>
                @if($event->dress_code_women)
                    <p>{{ $event->dress_code_women }}</p>
                @else
                    <p>{{ $event->dress_code }}</p>
                @endif
            </div>
        </div>
        @endif

        @if($event->dress_code_colors)
        <div class="dc-palette reveal">
            <div class="label">Por favor evita estos colores</div>
            <div class="dc-swatches">
                @foreach($event->dress_code_colors as $color)
                    <div class="dc-sw x" style="background:{{ $color['hex'] }}"
                         title="{{ $color['label'] ?? '' }}"></div>
                @endforeach
            </div>
            <div class="label" style="margin-top:18px;color:var(--terra-deep)">Reservados para la festejada</div>
        </div>
        @endif
    </section>
    @endif

    {{-- ── GIFTS ── --}}
    <section class="gifts">
        <div class="eyebrow reveal">Mesa de regalos</div>
        <h2 class="reveal">Tu presencia es <em>el mejor regalo</em></h2>
        <p class="note reveal">Si deseas obsequiar algo más, aquí encontrarás opciones para hacerlo con cariño.</p>
        <div class="gift-grid reveal-stagger">
            <div class="gift-card">
                <div class="brand">Liverpool</div>
                <div class="meta">Mesa de regalos</div>
                <div class="code">N° 5102 4477</div>
                <div class="arrow">Ver →</div>
            </div>
            <div class="gift-card">
                <div class="brand">Amazon</div>
                <div class="meta">Wishlist</div>
                <div class="code">{{ strtolower(str_replace(' ', '-', $event->name)) }}-xv-{{ $event->event_date->format('Y') }}</div>
                <div class="arrow">Ver →</div>
            </div>
            <div class="gift-card">
                <div class="brand">Sobre</div>
                <div class="meta">Lluvia de sobres</div>
                <div class="code">En el evento</div>
                <div class="arrow">Ver →</div>
            </div>
        </div>
    </section>

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <section class="rsvp">
        <div class="eyebrow reveal">Confirma tu asistencia</div>
        <h2 class="reveal" style="margin-top:18px">Confírmanos <em>antes del 15 de julio</em></h2>
        <p class="deadline reveal">Para reservar tu lugar en la mesa.</p>
        <div class="divider reveal" aria-hidden="true">
            <svg width="14" height="14" viewBox="0 0 14 14"><circle cx="7" cy="7" r="2" fill="currentColor"/></svg>
        </div>

        <form id="rsvp-form" class="reveal" novalidate>
            <div class="field">
                <label for="rsvp-name">Tu nombre</label>
                <input id="rsvp-name" type="text" placeholder="Nombre completo" autocomplete="name">
            </div>
            <div class="field">
                <label>¿Podrás asistir?</label>
                <div class="rsvp-options">
                    <button type="button" class="rsvp-opt" data-val="yes">Sí, ahí estaré</button>
                    <button type="button" class="rsvp-opt" data-val="no">No podré</button>
                </div>
            </div>
            <div class="field guests-field" id="guests-field">
                <label>Número de invitados</label>
                <div class="guests-row">
                    <button type="button" id="g-minus" disabled aria-label="Menos">−</button>
                    <div class="count" id="g-count">1</div>
                    <button type="button" id="g-plus" aria-label="Más">+</button>
                </div>
            </div>
            <div class="field">
                <label for="rsvp-msg">Un mensaje para {{ $event->name }} (opcional)</label>
                <textarea id="rsvp-msg" placeholder="Tus mejores deseos…"></textarea>
            </div>
            <button type="submit" class="rsvp-submit" id="rsvp-btn" disabled>Enviar confirmación</button>
        </form>

        <div class="rsvp-thanks" id="rsvp-thanks">
            <div class="icon">✓</div>
            <h3 id="thanks-title">¡Gracias!</h3>
            <p id="thanks-body">Tu respuesta fue registrada. Te esperamos el {{ $event->event_date->translatedFormat('d \d\e F') }}.</p>
        </div>
    </section>
    @endif

    {{-- ── CLOSING ── --}}
    <section class="closing">
        <svg class="branch tl" width="120" height="66" viewBox="0 0 200 110" fill="none" aria-hidden="true"><path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/><ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/><ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/><circle cx="170" cy="48" r="2.4" fill="currentColor"/></svg>
        <svg class="branch tr" width="120" height="66" viewBox="0 0 200 110" fill="none" aria-hidden="true"><path d="M10 90 Q60 70 110 70 T 190 50" stroke="currentColor" stroke-width="1.1" fill="none" stroke-linecap="round"/><ellipse cx="50" cy="76" rx="9" ry="3" fill="currentColor" transform="rotate(-20 50 76)"/><ellipse cx="95" cy="64" rx="9" ry="3" fill="currentColor" transform="rotate(-6 95 64)"/><circle cx="170" cy="48" r="2.4" fill="currentColor"/></svg>

        <div class="eyebrow reveal">Con todo el cariño de la familia.</div>
        <h2 class="reveal" style="margin-top:22px">Te esperamos <em>—</em></h2>
        <div class="stamp reveal">
            <div style="position:relative;z-index:1;text-align:center;line-height:1.4;">
                <div>{{ strtoupper($event->name) }}</div>
                <div style="font-size:14px;letter-spacing:0;font-family:var(--display);color:var(--terra);margin:4px 0">·</div>
                <div>XV · {{ $event->event_date->format('Y') }}</div>
            </div>
        </div>
        <p style="margin-top:50px;font-family:var(--serif);font-style:italic;color:var(--ink-soft)">
            {{ $event->event_date->format('d') }} · {{ ucfirst($event->event_date->translatedFormat('F')) }} · {{ $event->event_date->format('Y') }}
        </p>
    </section>

</main>

<script>
// ── ENVELOPE ──
(function () {
    const stage = document.getElementById('envelope-stage');
    const main  = document.getElementById('main-content');
    document.body.style.overflow = 'hidden';

    function open() {
        if (stage.classList.contains('open')) return;
        stage.classList.add('open');

        // Búsqueda lazy: el botón de música está después de este script en el DOM
        const iframe = document.getElementById('yt-iframe');
        const btn    = document.getElementById('yt-toggle');
        if (iframe && iframe.dataset.src) {
            iframe.src = iframe.dataset.src;
            if (btn) btn.textContent = '⏸';
        }

        setTimeout(() => {
            document.body.style.overflow = '';
            main.classList.add('visible');
            document.querySelectorAll('.reveal, .reveal-stagger').forEach(el => {
                const r = el.getBoundingClientRect();
                if (r.top < window.innerHeight) el.classList.add('in');
            });
        }, 1800);
    }

    stage.addEventListener('click', open);
    stage.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') open(); });
})();

// ── SCROLL REVEAL ──
(function () {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('in');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal, .reveal-stagger').forEach(el => io.observe(el));
})();

// ── COUNTDOWN ──
(function () {
    const target = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '18:00' }}');
    const pad = n => String(n).padStart(2, '0');

    function tick() {
        const diff = Math.max(0, target - Date.now());
        document.getElementById('cd-d').textContent = pad(Math.floor(diff / 86400000));
        document.getElementById('cd-h').textContent = pad(Math.floor(diff % 86400000 / 3600000));
        document.getElementById('cd-m').textContent = pad(Math.floor(diff % 3600000 / 60000));
        document.getElementById('cd-s').textContent = pad(Math.floor(diff % 60000 / 1000));
    }
    tick();
    setInterval(tick, 1000);
})();

// ── RSVP ──
(function () {
    const form = document.getElementById('rsvp-form');
    if (!form) return; // sección oculta cuando requires_rsvp = false

    let attending = null;
    let guests = 1;

    const btn       = document.getElementById('rsvp-btn');
    const thanks    = document.getElementById('rsvp-thanks');
    const gField    = document.getElementById('guests-field');
    const gMinus    = document.getElementById('g-minus');
    const gPlus     = document.getElementById('g-plus');
    const gCount    = document.getElementById('g-count');
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

    function updateBtn() {
        btn.disabled = !(nameInput.value.trim().length > 1 && attending !== null);
    }

    gMinus.addEventListener('click', () => {
        guests = Math.max(1, guests - 1);
        gCount.textContent = guests;
        gMinus.disabled = guests <= 1;
        gPlus.disabled  = guests >= 8;
    });
    gPlus.addEventListener('click', () => {
        guests = Math.min(8, guests + 1);
        gCount.textContent = guests;
        gMinus.disabled = guests <= 1;
        gPlus.disabled  = guests >= 8;
    });

    form.addEventListener('submit', e => {
        e.preventDefault();
        if (btn.disabled) return;
        const name = nameInput.value.trim();
        form.style.display = 'none';
        thanks.style.display = 'block';
        document.getElementById('thanks-title').textContent =
            attending === 'yes' ? `¡Gracias, ${name}!` : `Hasta pronto, ${name}`;
        document.getElementById('thanks-body').textContent =
            attending === 'yes'
                ? `Te esperamos junto a ${guests > 1 ? `tus ${guests - 1} acompañante${guests - 1 > 1 ? 's' : ''}` : 'nosotros'} el {{ $event->event_date->translatedFormat('d \d\e F') }}. ¡Nos vemos pronto!`
                : 'Lamentamos no poder contar contigo en esta ocasión. Gracias por avisarnos.';
    });
})();
</script>

{{-- ── MÚSICA DE FONDO (prueba) ── --}}
<div id="yt-player-wrap" style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:200;">
    <button id="yt-toggle"
            style="width:48px;height:48px;border-radius:50%;
                   background:var(--terra);color:var(--cream);
                   border:none;cursor:pointer;font-size:1.3rem;
                   box-shadow:0 4px 14px rgba(0,0,0,0.25);
                   display:flex;align-items:center;justify-content:center;
                   transition:background 0.2s;"
            title="Reproducir música"
            aria-label="Reproducir música de fondo">
        ▶
    </button>
    <iframe id="yt-iframe"
            src=""
            data-src="https://www.youtube.com/embed/VPRjCeoBqrI?autoplay=1&loop=1&playlist=VPRjCeoBqrI&controls=0&enablejsapi=1"
            allow="autoplay; encrypted-media"
            style="display:none;width:0;height:0;border:0;"
            title="Música de fondo">
    </iframe>
</div>

<script>
(function () {
    const btn    = document.getElementById('yt-toggle');
    const iframe = document.getElementById('yt-iframe');
    if (!btn || !iframe) return;

    let playing = false;

    // El sobre puede haber arrancado la música antes de que este script corra
    if (iframe.src) playing = true;

    btn.addEventListener('click', function () {
        if (playing) {
            iframe.src = '';
            btn.textContent = '▶';
            btn.title = 'Reproducir música';
        } else {
            iframe.src = iframe.dataset.src;
            btn.textContent = '⏸';
            btn.title = 'Pausar música';
        }
        playing = !playing;
    });
})();
</script>

</body>
</html>
