<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Invitaciones Digitales')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 flex items-center justify-between h-14">
            <div class="flex items-center gap-6">
                <a href="{{ route('dashboard') }}" class="font-semibold text-indigo-600 text-lg">
                    Invitaciones
                </a>
                <div class="hidden sm:flex items-center gap-1 text-sm">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-1.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }} transition">
                        Dashboard
                    </a>
                    <a href="{{ route('events.index') }}"
                       class="px-3 py-1.5 rounded-lg {{ request()->routeIs('events.*') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' }} transition">
                        Mis eventos
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="text-gray-500 hidden sm:block">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-400 hover:text-gray-700">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-5xl mx-auto px-4 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 rounded px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-5xl mx-auto px-4 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>

</body>
</html>
