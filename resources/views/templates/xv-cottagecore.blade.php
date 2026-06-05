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
                                <span style="font-size:0.75rem; color:var(--terracotta); white-space:nowrap; padding-top:2px;">{{ $item['time'] }}</span>
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
</script>

</body>
</html>
