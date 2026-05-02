<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-indigo-600">Invitaciones Digitales</h1>
            <p class="text-gray-500 text-sm mt-1">Recupera el acceso a tu cuenta</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">

            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <p class="text-sm text-gray-600 mb-5">
                Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.
            </p>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                                  @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg py-2.5 text-sm transition">
                    Enviar enlace
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">← Volver al inicio de sesión</a>
        </p>

    </div>
</div>

</body>
</html>
