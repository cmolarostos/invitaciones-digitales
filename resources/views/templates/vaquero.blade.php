<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rye&family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-western { font-family: 'Rye', cursive; }
        .font-display  { font-family: 'Playfair Display', serif; }
        .font-body     { font-family: 'Montserrat', sans-serif; }

        body {
            background-color: #fcf8f2;
            font-family: 'Montserrat', sans-serif;
            color: #431c01;
            overflow-x: hidden;
        }

        /* Dust particles */
        .dust-particle {
            position: fixed;
            background: rgba(225, 170, 110, 0.35);
            border-radius: 50%;
            pointer-events: none;
            animation: drift linear infinite;
        }
        @keyframes drift {
            0%   { transform: translateY(105vh) translateX(0px) scale(0.5); opacity: 0; }
            50%  { opacity: 0.5; }
            100% { transform: translateY(-5vh) translateX(100px) scale(1.2); opacity: 0; }
        }

        /* Tumbleweed */
        @keyframes tumble {
            0%   { transform: translateX(-120px) rotate(0deg); }
            100% { transform: translateX(105vw) rotate(1440deg); }
        }
        .tumbleweed { animation: tumble 18s linear infinite; }

        /* Swinging sign */
        @keyframes swing {
            0%   { transform: rotate(-2.5deg); }
            50%  { transform: rotate(2.5deg); }
            100% { transform: rotate(-2.5deg); }
        }
        .swinging-sign {
            transform-origin: top center;
            animation: swing 4s ease-in-out infinite;
        }

        /* Leather stitch */
        .leather-stitch {
            border: 2px dashed #b45309;
            box-shadow: 0 0 0 4px #fef3c7, inset 0 0 0 4px #fef3c7;
        }

        /* Cards */
        .wood-card {
            background: #faf4e8;
            border: 2px solid rgba(120, 53, 15, 0.15);
            border-radius: 16px;
        }

        /* Countdown boxes */
        .cd-box {
            background: #3e2000;
            border-radius: 10px;
            padding: 10px 6px;
            text-align: center;
        }
        .cd-num   { font-family: 'Rye', cursive; font-size: 1.8rem; color: #fef3c7; line-height: 1; }
        .cd-label { font-size: 0.6rem; letter-spacing: 0.2em; color: #d97706; text-transform: uppercase; margin-top: 4px; }

        /* Polaroid */
        .polaroid {
            background: white;
            padding: 14px 14px 44px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.18);
            border-radius: 2px;
            border: 1px solid #e5e7eb;
        }
        .polaroid-transition { transition: opacity 0.5s ease, transform 0.5s ease; }
    </style>
</head>
<body class="selection:bg-amber-800 selection:text-white">

{{-- Dust container --}}
<div id="dust-container" class="fixed inset-0 pointer-events-none z-10 overflow-hidden" aria-hidden="true"></div>

{{-- Tumbleweed --}}
<div class="fixed bottom-4 left-0 w-full pointer-events-none z-20 overflow-hidden h-16" aria-hidden="true">
    <div class="tumbleweed absolute bottom-0 text-amber-900/30 text-4xl">🌾</div>
</div>

{{-- Top border --}}
<div class="h-3 bg-gradient-to-r from-amber-900 via-yellow-700 to-amber-900 w-full"></div>

<main class="max-w-2xl mx-auto px-4 py-8 relative z-10">

    {{-- Swinging wooden sign header --}}
    <header class="fade-up delay-1 flex flex-col items-center text-center mt-6 mb-12">

        {{-- Ropes --}}
        <div class="flex gap-40 mb-0">
            <div class="w-1.5 h-10 bg-amber-900 rounded-sm"></div>
            <div class="w-1.5 h-10 bg-amber-900 rounded-sm"></div>
        </div>

        <div class="swinging-sign bg-amber-950 px-8 py-6 rounded-lg shadow-2xl border-4 border-amber-800 text-amber-100 w-full max-w-sm">
            <div class="border border-dashed border-amber-400/40 p-4 rounded">
                <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-1">
                    🤠 Estás invitado 🤠
                </span>
                <h1 class="font-western text-3xl uppercase tracking-wide leading-snug">
                    {{ $event->name }}
                </h1>
                <p class="text-xs mt-2 italic text-amber-300 opacity-80">
                    ¡Saca tu sombrero y tus mejores botas!
                </p>
            </div>
        </div>
    </header>

    {{-- Core card --}}
    <section class="bg-[#f5ebd6] rounded-3xl p-6 shadow-2xl border-4 border-amber-950 relative mb-10">

        {{-- Estrellas esquinas --}}
        <div class="absolute top-4 left-4 text-amber-800 text-2xl">✦</div>
        <div class="absolute top-4 right-4 text-amber-800 text-2xl">✦</div>
        <div class="absolute bottom-4 left-4 text-amber-800 text-xl">✦</div>
        <div class="absolute bottom-4 right-4 text-amber-800 text-xl">✦</div>

        <div class="leather-stitch rounded-2xl p-4 md:p-8 bg-[#fdfaf2]/90">

            {{-- Nombre del evento --}}
            <div class="fade-up delay-2 text-center mb-8">
                <span class="text-xs uppercase tracking-widest text-amber-800 font-bold">Únete a la celebración de</span>
                <h2 class="font-display text-5xl font-bold text-amber-900 my-2">{{ $event->name }}</h2>
                @if($event->notes)
                    <p class="text-sm text-amber-700 italic">"{{ $event->notes }}"</p>
                @endif
                <div class="w-24 h-1 bg-amber-800 mx-auto mt-4 rounded"></div>
            </div>

            {{-- Foto de portada --}}
            @if($cover = $event->coverPhoto())
                <div class="fade-up delay-2 flex justify-center mb-8">
                    <div class="polaroid max-w-xs w-full">
                        <img src="{{ $cover->url }}" alt="{{ $event->name }}"
                             class="w-full h-56 object-cover rounded-sm">
                        <p class="font-western text-amber-950 text-sm text-center mt-3">{{ $event->name }}</p>
                    </div>
                </div>
            @endif

            {{-- Cuenta regresiva --}}
            <div class="fade-up delay-3 bg-amber-900/10 rounded-xl p-5 mb-8 border border-amber-900/20">
                <h3 class="text-center font-western text-amber-900 text-base mb-4">La aventura comienza en...</h3>
                <div class="grid grid-cols-4 gap-2 max-w-xs mx-auto" id="countdown">
                    <div class="cd-box"><p class="cd-num" id="cd-days">--</p><p class="cd-label">Días</p></div>
                    <div class="cd-box"><p class="cd-num" id="cd-hours">--</p><p class="cd-label">Horas</p></div>
                    <div class="cd-box"><p class="cd-num" id="cd-mins">--</p><p class="cd-label">Min</p></div>
                    <div class="cd-box"><p class="cd-num" id="cd-secs">--</p><p class="cd-label">Seg</p></div>
                </div>
            </div>

            {{-- Carrusel de fotos tipo Polaroid --}}
            @if($event->photos->count() > 1)
                <div class="fade-up delay-3 mb-8">
                    <h3 class="text-center font-display font-bold text-xl text-amber-900 mb-6">
                        📷 Recuerdos del Rancho
                    </h3>
                    <div class="relative max-w-xs mx-auto h-80 flex items-center justify-center">
                        <div id="carousel-track" class="w-full h-full relative flex justify-center items-center">
                            @foreach($event->photos->skip(1)->take(6) as $i => $photo)
                                @php
                                    $rotations = ['rotate-2', '-rotate-3', 'rotate-1', '-rotate-2', 'rotate-3', '-rotate-1'];
                                    $rot = $rotations[$i % count($rotations)];
                                @endphp
                                <div class="carousel-slide absolute w-60 polaroid polaroid-transition
                                            {{ $i === 0 ? 'z-10 opacity-100 ' . $rot : 'z-0 opacity-0 pointer-events-none rotate-2' }}">
                                    <img src="{{ $photo->url }}" alt=""
                                         class="w-full h-44 object-cover rounded-sm">
                                    <p class="font-western text-amber-950 text-xs text-center mt-2">
                                        {{ $event->name }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <button onclick="prevSlide()"
                                class="absolute left-0 bg-amber-950 hover:bg-amber-800 text-amber-100 w-9 h-9 rounded-full flex items-center justify-center shadow-lg transition z-30">
                            ‹
                        </button>
                        <button onclick="nextSlide()"
                                class="absolute right-0 bg-amber-950 hover:bg-amber-800 text-amber-100 w-9 h-9 rounded-full flex items-center justify-center shadow-lg transition z-30">
                            ›
                        </button>
                    </div>
                </div>
            @endif

            {{-- Fecha y lugar --}}
            <div class="fade-up delay-4 grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">

                {{-- Fecha --}}
                <div class="wood-card p-5 text-center">
                    <p class="text-3xl mb-2">📅</p>
                    <h4 class="font-western text-base text-amber-900 mb-2">¿Cuándo es?</h4>
                    <p class="font-bold text-amber-950 capitalize">
                        {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
                    </p>
                    @if($event->event_time)
                        <p class="text-sm text-amber-800 mt-1">A partir de las {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
                    @endif
                </div>

                {{-- Lugar --}}
                @if($event->venue_name || $event->venue_address)
                    <div class="wood-card p-5 text-center">
                        <p class="text-3xl mb-2">📍</p>
                        <h4 class="font-western text-base text-amber-900 mb-2">¿Dónde es?</h4>
                        @if($event->venue_name)
                            <p class="font-bold text-amber-950">{{ $event->venue_name }}</p>
                        @endif
                        @if($event->venue_address)
                            <p class="text-sm text-amber-800 mt-1">{{ $event->venue_address }}</p>
                        @endif
                        @if($event->venue_maps_url)
                            <a href="{{ $event->venue_maps_url }}" target="_blank"
                               class="inline-block mt-3 bg-amber-800 hover:bg-amber-900 text-amber-50 text-xs font-bold px-4 py-2 rounded-lg transition">
                                Ver ubicación GPS
                            </a>
                        @endif
                    </div>
                @endif

            </div>

            {{-- Dress code --}}
            @if($event->dress_code)
                <div class="fade-up delay-5 border-2 border-dashed border-amber-700/40 rounded-2xl p-5 text-center bg-yellow-50/60">
                    <div class="flex justify-center gap-3 text-amber-800 text-3xl mb-2">🤠 👢</div>
                    <h4 class="font-western text-lg text-amber-900">Código de Vestimenta</h4>
                    <p class="font-bold text-amber-950 uppercase tracking-wider mt-1">{{ $event->dress_code }}</p>
                </div>
            @endif

            {{-- Itinerario --}}
            @if($event->itinerary)
                <div class="fade-up delay-6 wood-card p-5">
                    <h4 class="font-western text-base text-amber-900 text-center mb-4">📋 Programa del evento</h4>
                    <div class="divide-y divide-amber-200/60">
                        @foreach($event->itinerary as $item)
                            <div class="flex gap-3 {{ $loop->first ? '' : 'pt-3' }} {{ $loop->last ? '' : 'pb-3' }}">
                                @if(!empty($item['time']))
                                    <span class="font-body text-xs font-semibold text-amber-700 tabular-nums shrink-0 pt-0.5">{{ $item['time'] }}</span>
                                @endif
                                <div>
                                    <p class="font-display font-bold text-amber-950 text-sm">{{ $item['title'] }}</p>
                                    @if(!empty($item['description']))
                                        <p class="font-body text-xs text-amber-800/70 mt-0.5">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- Footer --}}
    <footer class="fade-up delay-7 text-center mb-12 text-amber-800 text-xs space-y-1">
        <p class="font-western text-sm">¡Saca brillo a la pista!</p>
        <p class="opacity-60">✦ ✦ ✦</p>
    </footer>

</main>

<script>
    // Dust particles
    function spawnDust() {
        const container = document.getElementById('dust-container');
        if (!container) return;
        const el = document.createElement('div');
        el.className = 'dust-particle';
        const size = Math.random() * 6 + 2;
        el.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}vw;animation-duration:${Math.random()*7+5}s;`;
        container.appendChild(el);
        setTimeout(() => el.remove(), 12000);
    }
    setInterval(spawnDust, 300);

    // Countdown
    const eventDate = new Date('{{ $event->event_date->format('Y-m-d') }}T{{ $event->event_time ?? '18:00' }}');
    function updateCountdown() {
        const diff = eventDate - Date.now();
        if (diff <= 0) {
            document.getElementById('countdown').innerHTML =
                '<p class="col-span-4 font-western text-center text-amber-900 text-lg">¡Hoy es el gran día! 🤠</p>';
            return;
        }
        document.getElementById('cd-days').textContent  = String(Math.floor(diff / 86400000)).padStart(2, '0');
        document.getElementById('cd-hours').textContent = String(Math.floor(diff % 86400000 / 3600000)).padStart(2, '0');
        document.getElementById('cd-mins').textContent  = String(Math.floor(diff % 3600000 / 60000)).padStart(2, '0');
        document.getElementById('cd-secs').textContent  = String(Math.floor(diff % 60000 / 1000)).padStart(2, '0');
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Polaroid carousel
    let current = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const rotations = ['rotate-2', '-rotate-3', 'rotate-1', '-rotate-2', 'rotate-3', '-rotate-1'];

    function updateCarousel() {
        slides.forEach((slide, i) => {
            slide.classList.remove('z-10', 'opacity-100', ...rotations);
            slide.classList.add('z-0', 'opacity-0', 'pointer-events-none');
            if (i === current) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('z-10', 'opacity-100', rotations[i % rotations.length]);
            }
        });
    }
    function nextSlide() { current = (current + 1) % slides.length; updateCarousel(); }
    function prevSlide() { current = (current - 1 + slides.length) % slides.length; updateCarousel(); }

    if (slides.length > 0) {
        updateCarousel();
        setInterval(nextSlide, 6000);
    }
</script>

</body>
</html>
