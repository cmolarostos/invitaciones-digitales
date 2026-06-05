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
                @foreach($event->photos->skip(1)->take(9) as $photo)
                    <div class="aspect-square overflow-hidden rounded-2xl">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
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
</script>

</body>
</html>
