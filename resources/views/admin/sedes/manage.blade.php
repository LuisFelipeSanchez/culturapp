@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">

    <div class="bg-mzl-blue shadow-lg pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-4">

                <div class="flex-shrink-0">
                    <img src="{{ asset('images/sec-cultura-logo.jpg') }}" alt="Secretaría de Cultura" class="h-12 sm:h-16 object-contain">
                </div>

                <div x-data="{ open: false }" class="relative w-full sm:w-auto">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center justify-between w-full sm:w-auto gap-2 bg-white text-mzl-blue px-4 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition text-sm">
                        <span class="truncate max-w-[200px] sm:max-w-xs">Gestionando: {{ $sede->name }}</span>
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-cloak x-show="open" x-transition class="absolute right-0 left-0 sm:left-auto mt-2 w-full sm:w-72 bg-white rounded-xl shadow-xl z-50 ring-1 ring-black ring-opacity-5">
                        <div class="py-1 max-h-96 overflow-y-auto">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Sedes Urbanas
                            </div>
                            @foreach($allSedes->where('zone', 'urbana') as $opcion)
                                <a href="{{ route('admin.manage', $opcion->id) }}" class="block px-4 py-2 text-sm {{ $sede->id === $opcion->id ? 'bg-mzl-blue text-white' : 'text-gray-700 hover:bg-mzl-teal hover:text-white' }}">
                                    {{ $opcion->name }}
                                </a>
                            @endforeach

                            <div class="border-t border-gray-100 mt-2"></div>
                            <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-1">
                                Sedes Rurales
                            </div>
                            @foreach($allSedes->where('zone', 'rural') as $opcion)
                                <a href="{{ route('admin.manage', $opcion->id) }}" class="block px-4 py-2 text-sm {{ $sede->id === $opcion->id ? 'bg-mzl-blue text-white' : 'text-gray-700 hover:bg-mzl-orange hover:text-white' }}">
                                    {{ $opcion->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ $sede->name }}</h1>
                <p class="text-gray-500 mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $sede->address }} - Zona {{ ucfirst($sede->zone) }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-end sm:items-center gap-3">
                @if(auth()->user()->isSuperAdmin() || auth()->user()->sede_id === $sede->id)
                <a href="{{ route('admin.manage.edit', $sede) }}" class="inline-flex items-center gap-2 bg-white text-mzl-blue border border-gray-200 font-bold px-4 py-2 rounded-xl text-sm shadow-sm hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar Sede
                </a>
                @endif
                <span class="px-4 py-2 rounded-full text-sm font-bold bg-mzl-teal bg-opacity-10 text-mzl-teal">
                    {{ $sede->courses->count() }} Cursos Activos
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-mzl-orange hover:shadow-md transition">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Oferta Académica</h2>
                <p class="text-gray-600 mb-4 text-sm">Gestiona los cursos, talleres y cupos de esta sede.</p>
                <a href="{{ route('admin.cursos.index', ['sede_id' => $sede->id]) }}" class="block w-full text-center bg-mzl-orange text-white font-bold py-2 rounded-lg hover:bg-opacity-90">Ver Cursos</a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-mzl-teal hover:shadow-md transition">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Inscripciones</h2>
                <p class="text-gray-600 mb-4 text-sm">Revisa los ciudadanos inscritos y sus notas.</p>
                <a href="{{ route('admin.cursos.index', ['sede_id' => $sede->id]) }}" class="block w-full text-center bg-mzl-teal text-white font-bold py-2 rounded-lg hover:bg-opacity-90">Ver Estudiantes</a>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-mzl-pink hover:shadow-md transition">
                <h2 class="text-xl font-bold text-gray-900 mb-2">Noticias y Eventos</h2>
                <p class="text-gray-600 mb-4 text-sm">Publica eventos específicos para esta comunidad.</p>
                <a href="{{ route('admin.noticias.index', ['sede_id' => $sede->id]) }}" class="block w-full text-center bg-mzl-pink text-white font-bold py-2 rounded-lg hover:bg-opacity-90">Ver Noticias</a>
            </div>
        </div>

    </div>
</div>
@endsection
