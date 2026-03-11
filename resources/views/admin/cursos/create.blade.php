@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center gap-2 text-white/60 text-xs mb-2">
                <a href="{{ route('admin.cursos.index') }}" class="hover:text-white transition">Cursos</a>
                <span>/</span>
                <span class="text-white">Nuevo curso</span>
            </div>
            <h1 class="text-white text-3xl font-black">Crear nuevo curso</h1>
            <p class="text-white/60 text-sm mt-1">Asocia el curso a una casa de la cultura y define todos sus detalles.</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-8 mt-8">

        <form method="POST" action="{{ route('admin.cursos.store') }}"
              enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm overflow-hidden">
            @csrf

            {{-- ── Sección 1: Sede y Categoría ── --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-900 text-base mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-mzl-blue text-white text-xs font-black flex items-center justify-center">1</span>
                    Casa de la Cultura y Categoría
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Sede --}}
                    <div>
                        <label for="sede_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Casa de la Cultura <span class="text-mzl-pink">*</span>
                        </label>
                        <select id="sede_id" name="sede_id" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition">
                            <option value="">— Selecciona una sede —</option>
                            @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}" {{ (old('sede_id', $selectedSede) == $sede->id) ? 'selected' : '' }}>
                                {{ $sede->name }} ({{ ucfirst($sede->zone) }})
                            </option>
                            @endforeach
                        </select>
                        @error('sede_id')
                        <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">
                            Categoría <span class="text-mzl-pink">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition">
                            <option value="">— Selecciona —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── Sección 2: Información del curso ── --}}
            <div class="px-6 py-5 border-b border-gray-100 space-y-5">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-mzl-teal text-white text-xs font-black flex items-center justify-center">2</span>
                    Información del curso
                </h2>

                {{-- Título --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nombre del curso <span class="text-mzl-pink">*</span>
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                           placeholder="Ej: Iniciación a la Pintura Acuarela"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition">
                    @error('title')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                        Descripción <span class="text-mzl-pink">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4" required
                              placeholder="Describe los objetivos, contenido y a quién va dirigido el curso..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm resize-none
                                     focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition">{{ old('description') }}</textarea>
                    @error('description')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Horario --}}
                <div>
                    <label for="schedule" class="block text-sm font-semibold text-gray-700 mb-1">
                        Horario <span class="text-mzl-pink">*</span>
                    </label>
                    <input id="schedule" type="text" name="schedule" value="{{ old('schedule') }}" required
                           placeholder="Ej: Lunes y Miércoles 2:00pm – 4:00pm"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:border-transparent transition">
                    @error('schedule')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ── Sección 3: Fechas y cupo ── --}}
            <div class="px-6 py-5 border-b border-gray-100 space-y-5">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-mzl-orange text-white text-xs font-black flex items-center justify-center">3</span>
                    Fechas y cupo
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-1">Fecha inicio <span class="text-mzl-pink">*</span></label>
                        <input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-mzl-blue transition">
                        @error('start_date')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-1">Fecha fin <span class="text-mzl-pink">*</span></label>
                        <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-mzl-blue transition">
                        @error('end_date')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-1">Cupo máx. <span class="text-mzl-pink">*</span></label>
                        <input id="capacity" type="number" name="capacity" value="{{ old('capacity', 20) }}" required min="1" max="500"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-mzl-blue transition">
                        @error('capacity')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="hours" class="block text-sm font-semibold text-gray-700 mb-1">Horas totales <span class="text-mzl-pink">*</span></label>
                        <div class="relative">
                            <input id="hours" type="number" name="hours" value="{{ old('hours', 40) }}" required min="1" max="9999"
                                   class="w-full px-4 py-3 pr-14 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-mzl-blue transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">hrs</span>
                        </div>
                        @error('hours')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Sección 4: Foto del curso ── --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2 mb-4">
                    <span class="w-6 h-6 rounded-full bg-mzl-teal text-white text-xs font-black flex items-center justify-center">4</span>
                    Foto del curso
                    <span class="text-xs text-gray-400 font-normal ml-1">(opcional)</span>
                </h2>
                <div class="flex items-center gap-5" id="img-wrapper">
                    <div class="w-28 h-28 rounded-2xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center shrink-0">
                        <img id="img-preview" src="" alt="" class="w-full h-full object-cover hidden">
                        <svg id="img-placeholder" class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <label for="image-input"
                               class="cursor-pointer inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2.5 rounded-xl transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Seleccionar imagen
                        </label>
                        <input type="file" id="image-input" name="image" accept="image/*" class="hidden">
                        <p class="text-gray-400 text-xs mt-2">JPG, PNG o WebP. Máx. 3 MB.</p>
                        @error('image')<p class="text-mzl-pink text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- ── Sección 5: Estado ── --}}
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="font-bold text-gray-900 text-base flex items-center gap-2 mb-4">
                    <span class="w-6 h-6 rounded-full bg-mzl-pink text-white text-xs font-black flex items-center justify-center">5</span>
                    Estado inicial
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach(['open' => ['Abierto','mzl-teal'], 'in_progress' => ['En progreso','mzl-orange'], 'finished' => ['Finalizado','gray-500'], 'cancelled' => ['Cancelado','mzl-pink']] as $val => [$label, $color])
                    <label class="flex items-center gap-2 px-3 py-2.5 rounded-xl border-2 cursor-pointer transition
                        {{ old('status', 'open') === $val ? 'border-mzl-blue bg-mzl-blue/5' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="status" value="{{ $val }}" {{ old('status', 'open') === $val ? 'checked' : '' }}
                               class="text-mzl-blue focus:ring-mzl-blue">
                        <span class="text-sm font-semibold text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                @error('status')<p class="text-mzl-pink text-xs mt-2">{{ $message }}</p>@enderror
            </div>

            {{-- Acciones --}}
            <div class="px-6 py-5 flex items-center justify-between gap-4">
                <a href="{{ route('admin.cursos.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 font-semibold transition">
                    ← Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-mzl-blue text-white font-bold px-7 py-3 rounded-xl
                               hover:bg-opacity-90 active:scale-95 transition-all shadow-md text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Crear curso
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('image-input').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (ev) => {
            const preview = document.getElementById('img-preview');
            const placeholder = document.getElementById('img-placeholder');
            preview.src = ev.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
