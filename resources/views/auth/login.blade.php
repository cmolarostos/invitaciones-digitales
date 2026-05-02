<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-indigo-600">Invitaciones Digitales</h1>
            <p class="text-gray-500 text-sm mt-1">Inicia sesión en tu cuenta</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
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

                <div>
                    <label class="block text-sm font-medium mb-1">Contraseña</label>
                    <input type="password" name="password"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400
                                  @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        Recordarme
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg py-2.5 text-sm transition">
                    Iniciar sesión
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">Regístrate gratis</a>
        </p>

    </div>
</div>

</body>
</html>
