@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Gestión / Cursos</p>
                <h1 class="text-white text-3xl font-black mt-1">Cursos</h1>
                <p class="text-white/60 text-sm mt-1">{{ $courses->total() }} curso(s) registrados</p>
            </div>
            <a href="{{ route('admin.cursos.create') }}"
               class="inline-flex items-center gap-2 bg-white text-mzl-blue font-bold px-5 py-2.5 rounded-xl shadow hover:bg-gray-50 transition text-sm self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Curso
            </a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-8 mt-8 space-y-6">

        {{-- Mensajes --}}
        @if(session('success'))
        <div class="bg-mzl-teal/10 border border-mzl-teal rounded-2xl p-4 flex items-center gap-3 text-mzl-teal text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-mzl-pink/10 border border-mzl-pink rounded-2xl p-4 flex items-center gap-3 text-mzl-pink text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Filtro por sede --}}
        <form method="GET" action="{{ route('admin.cursos.index') }}" class="flex flex-wrap gap-3 items-center">
            <select name="sede_id" onchange="this.form.submit()"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-mzl-blue">
                <option value="">Todas las sedes</option>
                @foreach($sedes as $sede)
                <option value="{{ $sede->id }}" {{ $selectedSede == $sede->id ? 'selected' : '' }}>{{ $sede->name }}</option>
                @endforeach
            </select>
            @if($selectedSede)
            <a href="{{ route('admin.cursos.index') }}" class="text-sm text-gray-400 hover:text-gray-700 transition">✕ Limpiar filtro</a>
            @endif
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="text-left px-6 py-3">Curso</th>
                            <th class="hidden lg:table-cell text-left px-6 py-3">Sede</th>
                            <th class="hidden md:table-cell text-left px-6 py-3">Categoría</th>
                            <th class="hidden sm:table-cell text-center px-6 py-3">Cupo</th>
                            <th class="hidden sm:table-cell text-center px-6 py-3">Horas</th>
                            <th class="hidden md:table-cell text-left px-6 py-3">Fechas</th>
                            <th class="hidden sm:table-cell text-center px-6 py-3">Estado</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($courses as $course)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $course->title }}</p>
                                <p class="text-gray-400 text-xs truncate max-w-xs">{{ $course->schedule }}</p>
                            </td>
                            <td class="hidden lg:table-cell px-6 py-4 text-gray-600">{{ $course->sede->name }}</td>
                            <td class="hidden md:table-cell px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-mzl-blue/10 text-mzl-blue text-xs font-semibold leading-none">
                                    <span class="text-sm leading-none">{{ $course->category->icon ?? '' }}</span>
                                    <span class="leading-none">{{ $course->category->name }}</span>
                                </span>
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4 text-center font-bold text-gray-700">{{ $course->capacity }}</td>
                            <td class="hidden sm:table-cell px-6 py-4 text-center text-gray-600">{{ $course->hours ?? '—' }}<span class="text-gray-400 text-xs ml-0.5">h</span></td>
                            <td class="hidden md:table-cell px-6 py-4 text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4 text-center">
                                @php
                                    $badge = match($course->status) {
                                        'open'        => 'bg-mzl-teal/10 text-mzl-teal',
                                        'in_progress' => 'bg-mzl-orange/10 text-mzl-orange',
                                        'finished'    => 'bg-gray-100 text-gray-500',
                                        'cancelled'   => 'bg-mzl-pink/10 text-mzl-pink',
                                        default       => 'bg-gray-100 text-gray-500',
                                    };
                                    $label = match($course->status) {
                                        'open'        => 'Abierto',
                                        'in_progress' => 'En progreso',
                                        'finished'    => 'Finalizado',
                                        'cancelled'   => 'Cancelado',
                                        default       => $course->status,
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badge }}">{{ $label }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cursos.show', $course) }}"
                                   class="text-mzl-blue text-xs font-bold hover:text-mzl-teal transition">Ver →</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-14 text-center text-gray-400">
                                <p class="text-4xl mb-3">📚</p>
                                <p class="font-semibold">No hay cursos registrados aún.</p>
                                <a href="{{ route('admin.cursos.create') }}" class="text-mzl-blue text-sm font-bold hover:underline mt-2 inline-block">Crear el primero →</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($courses->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $courses->appends(['sede_id' => $selectedSede])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
