<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de plantillas — Invitaciones Digitales</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased text-gray-800">

{{-- Header --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
        <a href="{{ route('catalog.index') }}" class="font-semibold text-indigo-600 text-lg">
            Invitaciones Digitales
        </a>
        <div class="flex items-center gap-3 text-sm">
            @auth
                <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-900">Mi panel</a>
            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Iniciar sesión</a>
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg transition">
                    Registrarse
                </a>
            @endauth
        </div>
    </div>
</header>

{{-- Hero --}}
<section class="bg-white border-b border-gray-100 py-16 text-center px-4">
    <h1 class="text-4xl font-bold text-gray-900 mb-3">Catálogo de plantillas</h1>
    <p class="text-gray-500 max-w-md mx-auto">
        Elige la plantilla perfecta para tu evento. Todas incluyen cuenta regresiva, galería de fotos y confirmación de asistencia.
    </p>
</section>

{{-- Filtro por tipo --}}
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex gap-2 overflow-x-auto pb-2 mb-10" id="type-filters">
        <button data-type="all"
                class="filter-btn active flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium border-2 border-indigo-500 bg-indigo-50 text-indigo-700 transition">
            Todos
        </button>
        @foreach ($eventTypes as $type)
            <button data-type="{{ $type->slug }}"
                    class="filter-btn flex-shrink-0 flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium border-2 border-gray-200 text-gray-600 hover:border-gray-300 transition">
                {{ $type->icon }} {{ $type->name }}
            </button>
        @endforeach
    </div>

    {{-- Grid de plantillas por tipo --}}
    @foreach ($eventTypes as $type)
        <section class="type-section mb-14" data-type="{{ $type->slug }}">
            <div class="flex items-center gap-3 mb-6">
                <span class="text-3xl">{{ $type->icon }}</span>
                <div>
                    <h2 class="text-xl font-bold">{{ $type->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $type->description }}</p>
                </div>
            </div>

            @if($type->templates->isEmpty())
                <p class="text-gray-400 text-sm">Próximamente...</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach ($type->templates as $template)
                        <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition hover:-translate-y-0.5">

                            {{-- Thumbnail / preview de colores --}}
                            <div class="aspect-[3/4] overflow-hidden relative"
                                 style="background: {{ $template->default_colors['background'] ?? '#f9fafb' }}">
                                @if($template->thumbnail_url)
                                    <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center gap-4 p-6">
                                        <div class="w-16 h-16 rounded-full shadow-inner"
                                             style="background: {{ $template->default_colors['primary'] ?? '#6366f1' }}"></div>
                                        <div class="space-y-2 w-full">
                                            <div class="h-2 rounded-full w-3/4 mx-auto opacity-30"
                                                 style="background: {{ $template->default_colors['text'] ?? '#111' }}"></div>
                                            <div class="h-2 rounded-full w-1/2 mx-auto opacity-20"
                                                 style="background: {{ $template->default_colors['text'] ?? '#111' }}"></div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Badge tipo --}}
                                <span class="absolute top-3 left-3 bg-white/80 backdrop-blur text-xs font-medium px-2 py-1 rounded-full border border-white">
                                    {{ $type->icon }} {{ $type->name }}
                                </span>
                            </div>

                            <div class="p-4">
                                <p class="font-semibold text-sm text-gray-800 mb-2">{{ $template->name }}</p>

                                {{-- Paleta --}}
                                <div class="flex gap-1.5 mb-4">
                                    @foreach(array_values($template->default_colors ?? []) as $color)
                                        <div class="w-4 h-4 rounded-full border border-gray-100 shadow-sm"
                                             style="background: {{ $color }}"></div>
                                    @endforeach
                                </div>

                                <a href="{{ route('events.create-with-template', $template) }}"
                                   class="block text-center text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-2 transition @guest hidden @endguest use-template-btn">
                                    Usar plantilla
                                </a>
                                @guest
                                    <a href="{{ route('register') }}"
                                       class="block text-center text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-2 transition">
                                        Comenzar gratis
                                    </a>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach
</div>

<script>
    const buttons  = document.querySelectorAll('.filter-btn');
    const sections = document.querySelectorAll('.type-section');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.type;

            buttons.forEach(b => {
                b.classList.remove('active', 'border-indigo-500', 'bg-indigo-50', 'text-indigo-700');
                b.classList.add('border-gray-200', 'text-gray-600');
            });
            btn.classList.add('active', 'border-indigo-500', 'bg-indigo-50', 'text-indigo-700');
            btn.classList.remove('border-gray-200', 'text-gray-600');

            sections.forEach(s => {
                s.style.display = (type === 'all' || s.dataset.type === type) ? '' : 'none';
            });
        });
    });
</script>

</body>
</html>
