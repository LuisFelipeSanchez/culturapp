@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-3xl mx-auto">
            <div class="flex items-center gap-2 text-white/60 text-xs mb-2">
                <a href="{{ route('admin.noticias.index') }}" class="hover:text-white transition">Noticias</a>
                <span>/</span>
                <span class="text-white">Editar</span>
            </div>
            <h1 class="text-white text-3xl font-black mt-1">Editar noticia: {{ $news->title }}</h1>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-8 mt-8">

        <form method="POST" action="{{ route('admin.noticias.update', $news) }}"
              enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @csrf @method('PUT')

            <div class="p-6 md:p-8 space-y-8">
                
                {{-- Info general --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-2">Información Básica</h2>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Título de la noticia *</label>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition">
                        @error('title') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Sede *</label>
                        <select name="sede_id" {{ !auth()->user()->isSuperAdmin() ? 'disabled' : '' }}
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition {{ !auth()->user()->isSuperAdmin() ? 'bg-gray-50' : '' }}">
                            @if(auth()->user()->isSuperAdmin())
                                <option value="">🌐 General (Toda la ciudad / Sin sede referenciada)</option>
                            @endif
                            @foreach($sedes as $s)
                            <option value="{{ $s->id }}" {{ old('sede_id', $news->sede_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} ({{ ucfirst($s->zone) }})
                            </option>
                            @endforeach
                        </select>
                        @if(!auth()->user()->isSuperAdmin())
                            <input type="hidden" name="sede_id" value="{{ auth()->user()->sede_id }}">
                        @endif
                        <p class="text-xs text-gray-400 mt-1">Las noticias generales aparecerán en el portal principal de la Secretaría. Las específicas de sede aparecerán en el perfil de esa sede.</p>
                        @error('sede_id') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Contenido *</label>
                        <textarea name="content" rows="5" required
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue focus:border-mzl-blue transition">{{ old('content', $news->content) }}</textarea>
                        @error('content') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Opcionales: Acción, Imagen y Estado --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-black text-gray-900 border-b border-gray-100 pb-2">Multimedia y Acciones</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Texto del botón de acción</label>
                            <input type="text" name="action_text" value="{{ old('action_text', $news->action_text) }}"
                                   class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue transition">
                            @error('action_text') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">URL del botón</label>
                            <input type="url" name="action_url" value="{{ old('action_url', $news->action_url) }}"
                                   class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-mzl-blue transition">
                            @error('action_url') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5 text-mzl-blue">Imagen de la noticia</label>
                        @if($news->image_url)
                        <div class="mb-3">
                            <span class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-wider">Imagen actual:</span>
                            <img src="{{ Str::startsWith($news->image_url, 'http') ? $news->image_url : asset($news->image_url) }}" alt="Current image" class="h-32 object-cover rounded-xl shadow border border-gray-200">
                        </div>
                        @else
                        <div class="mb-3 text-xs text-gray-500 font-semibold bg-gray-50 p-3 rounded-lg border border-gray-100 italic">No hay imagen asociada a esta noticia.</div>
                        @endif
                        <input type="file" name="image_url" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-mzl-blue/10 file:text-mzl-blue hover:file:bg-mzl-blue/20 transition cursor-pointer">
                        <p class="text-[11px] text-gray-400 mt-1">Si subes una nueva imagen, reemplazará la actual (máximo 2MB).</p>
                        @error('image_url') <span class="text-mzl-pink text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-gray-50 rounded-xl border border-gray-200 hover:bg-gray-100 transition">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                               class="w-5 h-5 rounded text-mzl-blue focus:ring-mzl-blue border-gray-300">
                        <div>
                            <span class="block text-sm font-bold text-gray-900">Mantener publicada</span>
                            <span class="block text-xs text-gray-500">Si desmarcas esta opción, la noticia quedará oculta al público.</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="px-6 py-5 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between gap-4">
                <a href="{{ route('admin.noticias.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 font-semibold transition">
                    ← Cancelar
                </a>
                <button type="submit"
                        class="bg-mzl-blue hover:bg-mzl-teal text-white font-bold py-2.5 px-8 rounded-xl shadow transition duration-200">
                    Actualizar Noticia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
