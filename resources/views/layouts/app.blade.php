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
            <a href="{{ route('events.index') }}" class="font-semibold text-indigo-600 text-lg">
                Invitaciones
            </a>
            <div class="flex items-center gap-4 text-sm">
                <span class="text-gray-500">{{ Auth::user()->name }}</span>
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
