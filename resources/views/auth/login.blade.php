<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                Correo electrónico
            </label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition"
                placeholder="tu@correo.com"
            >
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm" />
        </div>

        {{-- Contraseña --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                Contraseña
            </label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition"
                placeholder="••••••••"
            >
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm" />
        </div>

        {{-- Recuérdame + ¿Olvidaste tu contraseña? --}}
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer text-gray-600">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 text-mzl-blue shadow-sm focus:ring-mzl-blue">
                Recuérdame
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-mzl-blue hover:text-mzl-teal font-semibold transition">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        {{-- Botón de ingreso --}}
        <button type="submit"
                class="w-full py-3 bg-mzl-blue text-white font-bold text-base rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-md">
            Ingresar
        </button>

        {{-- Divider decorativo --}}
        <div class="flex items-center gap-3 my-2">
            <div class="flex-1 h-px bg-gray-200"></div>
            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wide">Cultura que nos une</span>
            <div class="flex-1 h-px bg-gray-200"></div>
        </div>

        {{-- Línea de color de marca abajo --}}
        <div class="flex gap-2 justify-center mt-2">
            <span class="flex-1 h-1 rounded-full bg-mzl-blue"></span>
            <span class="flex-1 h-1 rounded-full bg-mzl-teal"></span>
            <span class="flex-1 h-1 rounded-full bg-mzl-orange"></span>
            <span class="flex-1 h-1 rounded-full bg-mzl-pink"></span>
            <span class="flex-1 h-1 rounded-full bg-mzl-yellow"></span>
        </div>
    </form>
</x-guest-layout>
