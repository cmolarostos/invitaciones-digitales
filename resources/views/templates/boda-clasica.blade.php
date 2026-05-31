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
                    <p class="font-body text-sm text-stone-400 mt-1">{{ $event->event_time }} hrs</p>
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
                            <span class="font-body text-xs gold tabular-nums shrink-0 pt-0.5">{{ $item['time'] }}</span>
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
                @foreach($event->photos->skip(1)->take(9) as $photo)
                    <div class="aspect-square overflow-hidden rounded-sm">
                        <img src="{{ $photo->url }}" alt=""
                             class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                @endforeach
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
</script>

</body>
</html>
