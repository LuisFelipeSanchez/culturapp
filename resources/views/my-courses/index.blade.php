@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12" x-data="{ tab: 'inscritos' }">
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-white text-3xl font-black">Mis Cursos</h1>
            <p class="text-white/60 text-sm mt-1">Gestiona tus inscripciones y las clases que impartes.</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-8 mt-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 font-semibold text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Menú de Pestañas --}}
        <div class="bg-white rounded-2xl p-1.5 shadow-sm border border-gray-100 flex overflow-x-auto gap-1 mb-6">
            <button @click="tab = 'inscritos'" 
                    :class="tab === 'inscritos' ? 'bg-mzl-blue text-white shadow' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all whitespace-nowrap">
                Mis Inscripciones ({{ $myEnrollments->count() }})
            </button>
            
            @if($managedCourses->count() > 0)
            <button @click="tab = 'dictados'" 
                    :class="tab === 'dictados' ? 'bg-mzl-teal text-white shadow' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all whitespace-nowrap">
                Cursos que dicto ({{ $managedCourses->count() }})
            </button>
            <button @click="tab = 'pendientes'" 
                    :class="tab === 'pendientes' ? 'bg-mzl-orange text-white shadow' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all whitespace-nowrap flex items-center gap-2">
                Aprobaciones Pendientes
                @if($pendingEnrollments->count() > 0)
                    <span class="bg-white text-mzl-orange px-2 py-0.5 rounded-full text-xs shadow-sm">{{ $pendingEnrollments->count() }}</span>
                @endif
            </button>
            @endif
        </div>

        {{-- TAB 1: Mis Inscripciones --}}
        <div x-show="tab === 'inscritos'" x-transition.opacity.duration.300ms>
            @if($myEnrollments->isEmpty())
                <div class="bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">
                    <p class="text-gray-500 font-semibold mb-2">No estás inscrito en ningún curso actualmente.</p>
                    <a href="{{ route('sedes.index') }}" class="text-mzl-blue hover:underline font-bold text-sm">Explorar sedes y cursos →</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($myEnrollments as $enrollment)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group flex flex-col">
                        <div class="aspect-video bg-gray-100 relative overflow-hidden shrink-0">
                            @if($enrollment->course->image)
                                <img src="{{ $enrollment->course->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full bg-mzl-teal/10 flex items-center justify-center text-mzl-teal group-hover:scale-105 transition duration-500">
                                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3 flex gap-2">
                                @if($enrollment->status === 'enrolled')
                                    <span class="bg-green-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">Inscrito</span>
                                @elseif($enrollment->status === 'pending')
                                    <span class="bg-mzl-orange text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">En Revisión</span>
                                @elseif($enrollment->status === 'approved')
                                    <span class="bg-mzl-blue text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">Aprobado</span>
                                @elseif(in_array($enrollment->status, ['dropped', 'failed']))
                                    <span class="bg-mzl-pink text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">Inhabilitado</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <p class="text-xs text-mzl-blue font-black uppercase tracking-wider mb-1">{{ $enrollment->course->category->name }}</p>
                            <h3 class="font-black text-gray-900 text-lg mb-2 leading-tight">{{ $enrollment->course->title }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $enrollment->course->description }}</p>
                            <div class="mt-auto space-y-2">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">{{ $enrollment->course->sede->name }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="truncate">{{ $enrollment->course->formatted_schedule }}</span>
                                </div>
                            </div>
                            @if(in_array($enrollment->status, ['dropped', 'failed']) && auth()->user()->flagged_reason)
                                <div class="mt-4 bg-red-50 border border-red-100 p-3 rounded-xl text-red-600 text-xs">
                                    <p class="font-bold uppercase tracking-wider text-[10px] mb-1">Razón de inhabilitación:</p>
                                    <p class="italic">"{{ auth()->user()->flagged_reason }}"</p>
                                </div>
                            @endif
                            <a href="{{ route('cursos.show', $enrollment->course) }}" class="mt-5 w-full block text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 rounded-xl transition text-sm">
                                Ver detalle del curso
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- TAB 2: Cursos Dictados (Solo Encargados) --}}
        @if($managedCourses->count() > 0)
        <div x-show="tab === 'dictados'" x-cloak x-transition.opacity.duration.300ms>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($managedCourses as $course)
                <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm flex flex-col hover:border-mzl-teal transition">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">{{ $course->sede->name }}</p>
                    <h3 class="font-black text-gray-900 text-lg leading-tight mb-3">{{ $course->title }}</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600 mb-5">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="truncate">{{ $course->formatted_schedule }}</span>
                    </div>
                    
                    <a href="{{ route('my-courses.manage', $course) }}" class="mt-auto inline-flex items-center justify-center gap-2 bg-mzl-teal text-white font-bold px-4 py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Gestionar Alumnos
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- TAB 3: Aprobaciones Pendientes --}}
        <div x-show="tab === 'pendientes'" x-cloak x-transition.opacity.duration.300ms>
            @if($pendingEnrollments->isEmpty())
                <div class="bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-gray-500 font-semibold">No hay aprobaciones pendientes en este momento.</p>
                </div>
            @else
                <div class="bg-white border text-left border-gray-200 shadow-sm rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 font-bold text-gray-700 w-1/3">Alumnos en cuarentena</th>
                                    <th class="px-6 py-4 font-bold text-gray-700 text-center">Curso solicitado</th>
                                    <th class="px-6 py-4 font-bold text-gray-700 text-center">Razón de inhabilitación previa</th>
                                    <th class="px-6 py-4 font-bold text-gray-700 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($pendingEnrollments as $enrollment)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $enrollment->student->avatarUrl() }}" class="w-10 h-10 rounded-full bg-gray-100 border">
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $enrollment->student->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $enrollment->student->email }}</p>
                                                @if($enrollment->student->is_flagged)
                                                    <span class="inline-flex items-center gap-1 mt-1 font-bold text-[10px] text-mzl-pink bg-mzl-pink/10 px-2 py-0.5 rounded-md">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Sancionado
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <p class="font-bold text-gray-800">{{ $enrollment->course->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $enrollment->course->sede->name }}</p>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs text-center">
                                        @if($enrollment->student->flagged_reason)
                                            <p class="text-xs italic text-gray-600 bg-gray-100 p-2 rounded-lg inline-block text-left w-full">
                                                "{{ $enrollment->student->flagged_reason }}"
                                            </p>
                                        @else
                                            <p class="text-xs text-gray-400">Sin historial registrado.</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form method="POST" action="{{ route('my-courses.approve', $enrollment) }}">
                                                @csrf @method('PATCH')
                                                <button title="Aprobar inscripción" class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-500/10 text-green-600 hover:bg-green-500 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('my-courses.reject', $enrollment) }}">
                                                @csrf @method('PATCH')
                                                <button title="Rechazar inscripción" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-500/10 text-red-600 hover:bg-red-500 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        @endif

    </div>
</div>
@endsection
