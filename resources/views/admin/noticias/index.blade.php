@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    
    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="text-white text-3xl font-black mt-1">Noticias</h1>
                <p class="text-white/60 text-sm mt-1">{{ $news->total() }} noticia(s) registradas</p>
            </div>
            <a href="{{ route('admin.noticias.create', $selectedSede ? ['sede_id' => $selectedSede] : []) }}"
               class="inline-flex items-center gap-2 bg-white text-mzl-blue font-bold px-5 py-2.5 rounded-xl shadow hover:bg-gray-50 transition text-sm self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Crear noticia
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-8 mt-8 space-y-6">

        {{-- Filtro Activo --}}
        @if($selectedSede)
            @php $currentSede = $sedes->firstWhere('id', $selectedSede); @endphp
            @if($currentSede)
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-gray-500 uppercase tracking-widest">Filtrando por:</span>
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-mzl-blue/10 text-mzl-blue font-bold text-sm">
                    {{ $currentSede->name }}
                    <a href="{{ route('admin.noticias.index') }}" class="hover:text-mzl-pink transition ml-1" title="Quitar filtro">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                </span>
            </div>
            @endif
        @endif

        @if(session('success'))
        <div class="bg-mzl-teal/10 border border-mzl-teal rounded-2xl p-4 flex items-center gap-3 text-mzl-teal text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="px-6 py-4">Título</th>
                            <th class="hidden md:table-cell px-6 py-4">Sede asignada</th>
                            <th class="hidden sm:table-cell px-6 py-4">Estado</th>
                            <th class="hidden lg:table-cell px-6 py-4">Acción</th>
                            <th class="px-6 py-4 text-right">Ajustes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @forelse($news as $item)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 truncate max-w-[250px]">{{ $item->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4">
                                @if($item->sede_id)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-mzl-blue/10 text-mzl-blue">
                                        {{ $item->sede->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-widest">
                                        🌐 General
                                    </span>
                                @endif
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4 text-xs font-bold">
                                @if($item->is_published)
                                    <span class="text-mzl-teal">● Publicada</span>
                                @else
                                    <span class="text-gray-400">○ Oculta</span>
                                @endif
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4">
                                @if($item->action_text)
                                    <span class="text-xs font-semibold text-gray-500">{{ $item->action_text }}</span>
                                @else
                                    <span class="text-xs text-gray-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <a href="{{ route('admin.noticias.edit', $item) }}"
                                   class="text-mzl-blue text-xs font-bold hover:text-mzl-teal transition">Editar</a>
                                   
                                <form method="POST" action="{{ route('admin.noticias.destroy', $item) }}" class="inline-block" onsubmit="return confirm('¿Seguro de eliminar esta noticia?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-mzl-pink text-xs font-bold hover:underline transition">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-gray-400">
                                <p class="text-4xl mb-3">📭</p>
                                <p class="font-semibold">No hay noticias registradas aún.</p>
                                <a href="{{ route('admin.noticias.create') }}" class="text-mzl-blue text-sm font-bold hover:underline mt-2 inline-block">Crear la primera →</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($news->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $news->appends(['sede_id' => $selectedSede])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
