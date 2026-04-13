<x-guest-layout>
<style>
    /* ── Campos del formulario ── */
    .form-input {
        width: 100%; padding: .65rem 1rem; border-radius: .75rem;
        border: 1.5px solid #e5e7eb; background: #f9fafb;
        font-size: .95rem; color: #111827;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .form-input:focus {
        border-color: #3650BB;
        box-shadow: 0 0 0 3px #3650BB18;
        background: #fff;
    }
    .form-label { display: block; font-size: .8rem; font-weight: 700; color: #374151; margin-bottom: .35rem; text-transform: uppercase; letter-spacing: .05em; }

    /* ── Botón principal ── */
    .btn-primary {
        width: 100%; padding: .85rem 1.5rem; border-radius: .9rem;
        background: linear-gradient(135deg, #3650BB 0%, #0CB29C 100%);
        color: #fff; font-weight: 800; font-size: 1rem;
        border: none; cursor: pointer;
        transition: transform .15s ease, box-shadow .2s ease, opacity .2s;
        box-shadow: 0 4px 16px #3650BB33;
    }
    .btn-primary:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px #3650BB44; }
    .btn-primary:active:not(:disabled) { transform: scale(.98); }
</style>

<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Crear cuenta</h2>
        <p class="text-gray-500 text-sm mt-1">Ingresa tus datos para registrarte</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        <div class="mb-4">
            <label class="form-label" for="name">Nombre completo</label>
            <input id="name" name="name" type="text" class="form-input"
                   placeholder="Como aparece en tu documento"
                   value="{{ old('name') }}" required autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
        </div>

        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label class="form-label" for="document_type">Tipo</label>
                <select id="document_type" name="document_type" class="form-input" required>
                    <option value="">— Tipo —</option>
                    <option value="cc"        {{ old('document_type') === 'cc'        ? 'selected' : '' }}>Cédula (CC)</option>
                    <option value="ti"        {{ old('document_type') === 'ti'        ? 'selected' : '' }}>Tarjeta Identidad (TI)</option>
                    <option value="pasaporte" {{ old('document_type') === 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                    <option value="ce"        {{ old('document_type') === 'ce'        ? 'selected' : '' }}>Cédula Extranjería (CE)</option>
                </select>
                <x-input-error :messages="$errors->get('document_type')" class="mt-1 text-xs" />
            </div>
            <div>
                <label class="form-label" for="document_number">Número</label>
                <input id="document_number" name="document_number" type="text" class="form-input"
                       placeholder="1234567890" value="{{ old('document_number') }}" required>
                <x-input-error :messages="$errors->get('document_number')" class="mt-1 text-xs" />
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label" for="birth_date">Fecha de nacimiento</label>
            <input id="birth_date" name="birth_date" type="date" class="form-input"
                   value="{{ old('birth_date') }}" required>
            <x-input-error :messages="$errors->get('birth_date')" class="mt-1 text-xs" />
        </div>

        <div class="flex items-center gap-2 my-4">
            <div class="flex-1 h-px" style="background:#e5e7eb"></div>
            <span class="text-xs font-bold uppercase tracking-widest" style="color:#9ca3af">Datos de acceso</span>
            <div class="flex-1 h-px" style="background:#e5e7eb"></div>
        </div>

        <div class="mb-4">
            <label class="form-label" for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" class="form-input"
                   placeholder="tu@correo.com" value="{{ old('email') }}"
                   required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div class="mb-4">
            <label class="form-label" for="password">Contraseña</label>
            <div class="relative">
                <input id="password" name="password" type="password" class="form-input pr-10"
                       placeholder="Mínimo 8 caracteres" required autocomplete="new-password">
                <button type="button" onclick="togglePwd('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <div class="mb-5">
            <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="form-input" placeholder="Repite tu contraseña" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
        </div>

        <button type="submit" id="btn-register" class="btn-primary" style="position:relative;overflow:hidden;">
            Crear cuenta Segura
        </button>

        <div class="flex items-center justify-center mt-6 text-sm">
            <span style="color:#6b7280;" class="mr-2">¿Ya tienes cuenta?</span>
            <a href="{{ route('login') }}" class="font-semibold transition" style="color:#3650BB;"
               onmouseover="this.style.color='#0CB29C'" onmouseout="this.style.color='#3650BB'">
                Inicia sesión aquí
            </a>
        </div>
    </form>

    <div class="flex gap-2 mt-6">
        <span class="flex-1 h-1 rounded-full" style="background:#3650BB"></span>
        <span class="flex-1 h-1 rounded-full" style="background:#0CB29C"></span>
        <span class="flex-1 h-1 rounded-full" style="background:#FF6702"></span>
        <span class="flex-1 h-1 rounded-full" style="background:#E92050"></span>
        <span class="flex-1 h-1 rounded-full" style="background:#FFC400"></span>
    </div>
</div>

<script>
function togglePwd(id, btn) {
    const inp = document.getElementById(id);
    const isText = inp.type === 'text';
    inp.type = isText ? 'password' : 'text';
    btn.style.opacity = isText ? '1' : '.5';
}
</script>
</x-guest-layout>
