@extends('layouts.public')

@section('title', $event->name)

@section('content')
<div class="min-h-screen bg-stone-50 flex flex-col items-center justify-center px-4 py-16 text-center">

    {{-- Portada --}}
    @if($cover = $event->coverPhoto())
        <img src="{{ $cover->url }}" alt="{{ $event->name }}"
             class="fade-up delay-1 w-full max-w-lg rounded-2xl shadow-md mb-10 object-cover max-h-80">
    @endif

    <p class="fade-up delay-1 text-sm uppercase tracking-widest text-stone-400 mb-2">Te invitamos a celebrar</p>
    <h1 class="fade-up delay-2 text-4xl font-serif font-bold text-stone-800">{{ $event->name }}</h1>

    <div class="fade-up delay-3 my-8 flex flex-col gap-2 text-stone-600 text-sm">
        <p class="text-lg font-medium">
            {{ $event->event_date->translatedFormat('l d \d\e F \d\e Y') }}
        </p>
        @if($event->event_time)
            <p>{{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}</p>
        @endif
        @if($event->venue_name)
            <p class="font-medium">{{ $event->venue_name }}</p>
        @endif
        @if($event->venue_address)
            <p>{{ $event->venue_address }}</p>
        @endif
    </div>

    @if($event->venue_maps_url)
        <a href="{{ $event->venue_maps_url }}" target="_blank"
           class="fade-up delay-4 mb-6 text-sm text-indigo-600 hover:underline">
            📍 Ver en Google Maps
        </a>
    @endif

    @if($event->dress_code)
        <div class="fade-up delay-5 text-sm text-stone-500 mb-6">
            <p>Vestimenta: <strong>{{ $event->dress_code }}</strong></p>
            @if($event->dress_code_colors)
                <div style="margin-top:12px; text-align:center;">
                    <p style="font-size:0.7rem; letter-spacing:0.15em; text-transform:uppercase; color:#a8a29e; margin-bottom:8px;">Por favor evita estos colores</p>
                    <div style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                        @foreach($event->dress_code_colors as $color)
                            <div title="{{ $color['label'] ?? '' }}"
                                 style="width:26px;height:26px;border-radius:50%;background:{{ $color['hex'] }};box-shadow:0 0 0 1px rgba(0,0,0,.08);position:relative;">
                                <span style="position:absolute;inset:-2px;border-radius:50%;border:1px solid #78716c;background:linear-gradient(45deg,transparent calc(50% - 0.5px),#78716c 50%,transparent calc(50% + 0.5px));display:block;"></span>
                            </div>
                        @endforeach
                    </div>
                    <p style="font-size:0.7rem; color:#78716c; margin-top:8px;">Reservados para la festejada</p>
                    @if($event->dress_code_colors_note)
                        <p style="font-size:0.72rem; color:#a8a29e; margin-top:4px; font-style:italic;">{{ $event->dress_code_colors_note }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    @if($event->notes)
        <p class="fade-up delay-5 text-sm text-stone-500 max-w-sm mb-8">{{ $event->notes }}</p>
    @endif

    {{-- Galería --}}
    @if($event->photos->count() > 1)
        <div class="fade-up delay-6 grid grid-cols-3 gap-2 max-w-lg w-full mb-10">
            @foreach($event->photos->skip(1)->take(6) as $photo)
                <img src="{{ $photo->url }}" alt=""
                     class="w-full aspect-square object-cover rounded-lg">
            @endforeach
        </div>
    @endif

    {{-- ── RSVP ── --}}
    @if($event->requires_rsvp)
    <style>
        .rsvp-opt.selected { border-color:#78716c !important; font-weight:600; background:#f5f5f4 !important; }
        #rsvp-btn:not([disabled]) { opacity:1 !important; }
    </style>
    <div class="fade-up delay-6 w-full max-w-sm mb-8 text-left">
        <p class="text-xs uppercase tracking-widest text-stone-400 mb-1 text-center">Confirma tu asistencia</p>
        <p class="text-xl text-stone-600 mb-4 text-center">¿Nos acompañas?</p>
        <form id="rsvp-form" novalidate>
            <div style="margin-bottom:10px;">
                <input id="rsvp-name" type="text" placeholder="Tu nombre completo" autocomplete="name"
                       class="w-full border border-stone-200 rounded-lg px-3 py-2 text-sm outline-none" style="font-family:inherit;">
            </div>
            <div style="display:flex;gap:8px;justify-content:center;margin-bottom:10px;">
                <button type="button" class="rsvp-opt" data-val="yes"
                        style="flex:1;padding:8px;border:1px solid #e7e5e4;border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:#57534e;font-family:inherit;transition:all 0.2s;">
                    Sí, ahí estaré
                </button>
                <button type="button" class="rsvp-opt" data-val="no"
                        style="flex:1;padding:8px;border:1px solid #e7e5e4;border-radius:8px;font-size:0.8rem;background:transparent;cursor:pointer;color:#a8a29e;font-family:inherit;transition:all 0.2s;">
                    No podré
                </button>
            </div>
            <div id="guests-field" style="display:none;align-items:center;justify-content:center;gap:12px;margin-bottom:10px;">
                <span class="text-xs text-stone-400">Invitados:</span>
                <button type="button" id="g-minus" disabled style="width:28px;height:28px;border:1px solid #e7e5e4;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#57534e;">−</button>
                <span id="g-count" class="text-stone-600" style="font-size:1rem;min-width:20px;text-align:center;">1</span>
                <button type="button" id="g-plus" style="width:28px;height:28px;border:1px solid #78716c;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:#57534e;">+</button>
            </div>
            <button type="submit" id="rsvp-btn" disabled
                    class="w-full py-2 rounded-lg text-sm text-white"
                    style="background:#78716c;border:none;cursor:pointer;opacity:0.45;transition:opacity 0.2s;font-family:inherit;">
                Enviar confirmación
            </button>
        </form>
        <div id="rsvp-thanks" style="display:none;padding:16px 0;text-align:center;">
            <p class="text-2xl text-stone-400">✓</p>
            <h3 id="thanks-title" class="text-lg text-stone-600 mt-1"></h3>
            <p id="thanks-body" class="text-sm text-stone-400 mt-2"></p>
        </div>
    </div>
    @endif

    {{-- Cierre --}}
    <div class="fade-up delay-7 text-center mb-10">
        <p class="text-lg text-stone-500 italic">Con cariño,</p>
        <p class="text-2xl text-stone-700 mt-1">{{ $event->name }}</p>
        <p class="text-stone-300 mt-4 tracking-widest">· · ·</p>
    </div>

</div>

<script>
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
@endsection
