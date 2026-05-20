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
            @if($event->event_time) · {{ $event->event_time }} hrs @endif
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
                <div class="card p-4 flex items-center gap-3">
                    <span class="text-2xl">👔</span>
                    <div>
                        <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest">Vestimenta</p>
                        <p class="font-bold text-gray-900 text-sm">{{ $event->dress_code }}</p>
                    </div>
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
</script>

</body>
</html>
