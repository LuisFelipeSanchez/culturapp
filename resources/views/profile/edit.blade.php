@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-16">

    {{-- Header con gradiente de marca --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-4xl mx-auto flex items-center gap-6">
            {{-- Avatar con preview --}}
            <div class="relative group" id="avatar-wrapper">
                <img id="avatar-preview"
                     src="{{ $user->avatarUrl() }}"
                     alt="Foto de perfil"
                     class="w-24 h-24 rounded-full object-cover border-4 border-white/30 shadow-xl">
                <label for="avatar-input"
                       class="absolute inset-0 rounded-full bg-black/50 flex items-center justify-center
                              opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
            </div>
            <div>
                <h1 class="text-white text-2xl sm:text-3xl font-black">{{ $user->name }}</h1>
                <p class="text-white/60 text-sm mt-1">{{ $user->email }}</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold
                    {{ $user->isSuperAdmin() ? 'bg-mzl-yellow/20 text-mzl-yellow' :
                       ($user->isAdmin() ? 'bg-mzl-teal/20 text-mzl-teal' : 'bg-white/10 text-white/70') }}">
                    {{ $user->isSuperAdmin() ? 'Super Admin' : ($user->isAdmin() ? 'Administrador' : 'Ciudadano') }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 mt-8 space-y-6">

        {{-- Mensaje de éxito --}}
        @if(session('status') === 'profile-updated')
        <div class="bg-mzl-teal/10 border border-mzl-teal rounded-2xl p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-mzl-teal shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-mzl-teal font-semibold text-sm">Perfil actualizado correctamente.</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ══ COLUMNA IZQUIERDA: Datos no editables ══ --}}
            <div class="lg:col-span-1 space-y-4">

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-mzl-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h2 class="font-bold text-gray-900 text-sm">Datos de identidad</h2>
                    </div>
                    <div class="p-5 space-y-4">
                        <p class="text-xs text-gray-400 leading-snug">
                            Estos datos son gestionados por la administración y no pueden ser modificados desde aquí.
                        </p>

                        {{-- Nombre --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Nombre completo</label>
                            <p class="text-gray-800 font-semibold mt-1">{{ $user->name }}</p>
                        </div>

                        {{-- Tipo de documento --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tipo de documento</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                {{ $user->document_type ? $user->documentTypeLabel() : '—' }}
                            </p>
                        </div>

                        {{-- Número de documento --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">N° de documento</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                {{ $user->document_number ?? '—' }}
                            </p>
                        </div>

                        {{-- Fecha de nacimiento --}}
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wide">Fecha de nacimiento</label>
                            <p class="text-gray-800 font-semibold mt-1">
                                {{ $user->birth_date ? $user->birth_date->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Barra de colores de marca / decorativa --}}
                <div class="flex h-2 rounded-full overflow-hidden shadow-sm">
                    <div class="flex-1 bg-mzl-blue"></div>
                    <div class="flex-1 bg-mzl-teal"></div>
                    <div class="flex-1 bg-mzl-orange"></div>
                    <div class="flex-1 bg-mzl-pink"></div>
                    <div class="flex-1 bg-mzl-yellow"></div>
                </div>
            </div>

            {{-- ══ COLUMNA DERECHA: Formulario editable ══ --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Formulario de perfil --}}
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                      id="profile-form" class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    @csrf
                    @method('patch')

                    {{-- Input oculto del avatar --}}
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden">

                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-mzl-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h2 class="font-bold text-gray-900 text-sm">Información de contacto</h2>
                    </div>

                    <div class="p-6 space-y-5">

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                                Correo electrónico
                            </label>
                            <input id="email" type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50
                                          focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition text-sm">
                            @error('email')
                            <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">
                                Teléfono / Celular
                            </label>
                            <input id="phone" type="tel" name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="Ej: 310 123 4567"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50
                                          focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition text-sm">
                            @error('phone')
                            <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1">
                                Dirección
                            </label>
                            <input id="address" type="text" name="address"
                                   value="{{ old('address', $user->address) }}"
                                   placeholder="Ej: Cra 23 #18-05, Manizales"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50
                                          focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition text-sm">
                            @error('address')
                            <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Avatar info --}}
                        @error('avatar')
                        <p class="text-mzl-pink text-xs">{{ $message }}</p>
                        @enderror

                        {{-- Botón guardar --}}
                        <div class="pt-2">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-mzl-blue text-white font-bold
                                           px-6 py-3 rounded-xl hover:bg-opacity-90 active:scale-95 transition-all shadow-md text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Zona de peligro: eliminar cuenta --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-red-100">
                    <div class="px-6 py-4 border-b border-red-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-mzl-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h2 class="font-bold text-red-600 text-sm">Zona de peligro</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-500 text-sm mb-4">
                            Una vez que elimines tu cuenta, todos sus datos serán borrados permanentemente. Esta acción no se puede deshacer.
                        </p>
                        <form method="POST" action="{{ route('profile.destroy') }}"
                              onsubmit="return confirm('¿Estás seguro? Esta acción es irreversible.')">
                            @csrf
                            @method('delete')
                            <div class="mb-4">
                                <label for="del-password" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Confirma tu contraseña para continuar
                                </label>
                                <input id="del-password" type="password" name="password"
                                       class="w-full px-4 py-3 rounded-xl border border-red-200 bg-red-50
                                              focus:outline-none focus:ring-2 focus:ring-mzl-pink text-sm">
                                @error('password', 'userDeletion')
                                <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 bg-mzl-pink text-white font-bold
                                           px-5 py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar mi cuenta
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Preview del avatar antes de subir --}}
<script>
    document.getElementById('avatar-input').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            document.getElementById('avatar-preview').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
