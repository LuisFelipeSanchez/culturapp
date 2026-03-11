@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 text-white/60 text-xs mb-2">
                <a href="{{ route('admin.manage', $sede) }}" class="hover:text-white transition">Gestión de Sedes</a>
                <span>/</span>
                <span class="text-white">{{ $sede->name }}</span>
            </div>
            <h1 class="text-white text-3xl font-black mt-1">Editar Información de la Casa de la Cultura</h1>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 mt-8">
        <form method="POST" action="{{ route('admin.manage.update', $sede) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-6 md:p-8 space-y-8">
                
                {{-- Info general --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-2">Información Básica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Nombre de la Sede *</label>
                            <input type="text" name="name" value="{{ old('name', $sede->name) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition">
                            @error('name') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Dirección *</label>
                            <input type="text" name="address" value="{{ old('address', $sede->address) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition">
                            @error('address') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Zona *</label>
                            <select name="zone" required
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition">
                                <option value="urbana" {{ old('zone', $sede->zone) === 'urbana' ? 'selected' : '' }}>Urbana</option>
                                <option value="rural" {{ old('zone', $sede->zone) === 'rural' ? 'selected' : '' }}>Rural</option>
                            </select>
                            @error('zone') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Latitud</label>
                            <input type="text" name="latitude" value="{{ old('latitude', $sede->latitude) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                   placeholder="Ej: 5.0688">
                            @error('latitude') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Longitud</label>
                            <input type="text" name="longitude" value="{{ old('longitude', $sede->longitude) }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                   placeholder="Ej: -75.5174">
                            @error('longitude') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Descripción</label>
                        <textarea name="description" rows="5"
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                  placeholder="Escribe una pequeña reseña sobre esta Casa de la Cultura...">{{ old('description', $sede->description) }}</textarea>
                        @error('description') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Info de Contacto --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-2">Información de Contacto</h2>

                    @php
                        $contact = $sede->contact_info ?? [];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Teléfono Fijo / Móvil</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $contact['telefono'] ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                   placeholder="Ej: 606 887 9700">
                            @error('telefono') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $contact['whatsapp'] ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                   placeholder="Ej: 300 123 4567">
                            @error('whatsapp') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Enlace de Instagram</label>
                            <input type="url" name="instagram" value="{{ old('instagram', $contact['instagram'] ?? '') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition"
                                   placeholder="https://instagram.com/sedecultural">
                            @error('instagram') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Multimedia --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-2">Multimedia</h2>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Foto de la Sede</label>
                        @if($sede->image_url)
                        <div class="mb-3">
                            <span class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Imagen actual:</span>
                            <img src="{{ Str::startsWith($sede->image_url, 'http') ? $sede->image_url : asset($sede->image_url) }}" alt="Foto de la sede" class="h-40 w-auto object-cover rounded-xl shadow-md border border-gray-200">
                        </div>
                        @else
                        <div class="mb-3 text-xs text-gray-500 font-semibold bg-gray-50 p-4 rounded-xl border border-gray-100 italic">Esta sede aún no tiene foto.</div>
                        @endif
                        <input type="file" name="image_url" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-mzl-blue/10 file:text-mzl-blue hover:file:bg-mzl-blue/20 transition cursor-pointer mt-2">
                        <p class="text-[11px] text-gray-400 mt-1">Si subes una nueva imagen, reemplazará a la actual (máximo 2MB).</p>
                        @error('image_url') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

            </div>

            {{-- Acciones --}}
            <div class="px-6 py-5 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between gap-4">
                <a href="{{ route('admin.manage', $sede) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 font-semibold transition">
                    ← Cancelar
                </a>
                <button type="submit"
                        class="bg-mzl-blue hover:bg-mzl-teal text-white font-bold py-2.5 px-8 rounded-xl shadow transition duration-200">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
