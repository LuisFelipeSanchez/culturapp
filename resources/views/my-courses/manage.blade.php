@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">
    {{-- Usamos bg-mzl-blue con estilo inline de gradiente para garantizar compatibilidad sin depender del compilador JIT de tailwind al instante --}}
    <div class="bg-mzl-blue px-4 sm:px-8 py-10 text-white" style="background: linear-gradient(135deg, #0CB29C 0%, #3650BB 100%);">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-2 text-white/70 text-xs mb-2">
                <a href="{{ route('my-courses.index') }}" class="hover:text-white transition">Mis Cursos</a>
                <span>/</span>
                <span class="text-white font-bold">Gestión de Alumnos</span>
            </div>
            <h1 class="text-3xl font-black mb-1 truncate text-white" style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">{{ $course->title }}</h1>
            <p class="text-white/80 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $course->sede->name }}
            </p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-8 mt-6" x-data="{ tab: 'estudiantes' }">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 font-semibold text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Menú de Pestañas --}}
        <div class="bg-white rounded-2xl p-1.5 shadow-sm border border-gray-100 flex overflow-x-auto gap-1 mb-6">
            <button @click="tab = 'estudiantes'" 
                    :class="tab === 'estudiantes' ? 'bg-mzl-teal text-white shadow' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all whitespace-nowrap">
                Estudiantes Inscritos
            </button>
            
            <button @click="tab = 'actividades'" 
                    :class="tab === 'actividades' ? 'bg-mzl-blue text-white shadow' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"
                    class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all whitespace-nowrap flex items-center gap-2">
                Actividades y Calificaciones
                <span class="bg-white/20 text-white px-2 py-0.5 rounded-full text-xs shadow-sm" x-show="tab === 'actividades'">{{ $course->activities->count() }}</span>
            </button>
        </div>

        {{-- TAB 1: Estudiantes --}}
        <div x-show="tab === 'estudiantes'" x-transition.opacity.duration.300ms class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @php
                $activeEnrollments = $enrollments->whereNotIn('status', ['dropped', 'failed'])->unique('user_id')->values();
                $inactiveEnrollments = $enrollments->whereIn('status', ['dropped', 'failed'])->unique('user_id')->values();
            @endphp
            
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white mt-4">
                <h2 class="font-black text-gray-900 whitespace-nowrap">Estudiantes Inscritos ({{ $activeEnrollments->count() }})</h2>
            </div>
            
            @if($activeEnrollments->isEmpty())
                <div class="p-10 text-center bg-white">
                    <p class="text-gray-500 font-semibold mb-2">Aún no tienes alumnos inscritos en este curso.</p>
                </div>
            @else
                <div class="overflow-x-auto bg-white">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 w-10 text-center">#</th>
                                <th class="px-6 py-4">Usuario</th>
                                <th class="px-6 py-4 text-center">Documento</th>
                                <th class="px-6 py-4 text-center">Estado de inscripción</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($activeEnrollments as $index => $enrollment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-center text-xs text-gray-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $enrollment->student->avatarUrl() }}" class="w-9 h-9 rounded-full border bg-white">
                                        <div>
                                            <p class="font-bold text-gray-900 leading-none mb-1">{{ $enrollment->student->name }}</p>
                                            <p class="text-[11px] text-gray-500">{{ $enrollment->student->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold text-gray-700">
                                    {{ strtoupper($enrollment->student->document_type) }} {{ $enrollment->student->document_number }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($enrollment->status === 'enrolled')
                                        <span class="inline-flex flex-col items-center">
                                            <span class="text-[10px] font-black uppercase text-green-600 bg-green-50 px-2 py-0.5 rounded-md">Vigente</span>
                                        </span>
                                    @elseif($enrollment->status === 'pending')
                                        <span class="inline-flex flex-col items-center">
                                            <span class="text-[10px] font-black uppercase text-mzl-orange bg-mzl-orange/10 px-2 py-0.5 rounded-md">Pendiente</span>
                                        </span>
                                    @elseif($enrollment->status === 'approved')
                                        <span class="inline-flex flex-col items-center">
                                            <span class="text-[10px] font-black uppercase text-mzl-blue bg-mzl-blue/10 px-2 py-0.5 rounded-md">Aprobado</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('my-courses.disable', $enrollment) }}" class="disable-form inline-block">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="comment" class="comment-input" value="">
                                        <button type="button" class="disable-btn text-xs font-bold text-mzl-pink bg-mzl-pink/10 hover:bg-mzl-pink hover:text-white px-3 py-1.5 rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-mzl-pink">
                                            Inhabilitar...
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Historial de Inhabilitados --}}
            @if($inactiveEnrollments->isNotEmpty())
            <div class="px-6 py-4 border-t-4 border-gray-100 flex items-center justify-between bg-gray-50 mt-4">
                <h2 class="font-black text-gray-600 whitespace-nowrap"><svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Historial Inhabilitados / Retirados ({{ $inactiveEnrollments->count() }})</h2>
            </div>
            <div class="overflow-x-auto bg-white border-t border-gray-100">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-400 font-bold border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 w-10 text-center">#</th>
                            <th class="px-6 py-3">Usuario Sancionado</th>
                            <th class="px-6 py-3">Motivo de sanción registrada</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 opacity-80 hover:opacity-100 transition-opacity">
                        @foreach($inactiveEnrollments as $index => $enrollment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-center text-xs text-gray-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-white/50 rounded-full"></div>
                                        <img src="{{ $enrollment->student->avatarUrl() }}" class="w-9 h-9 rounded-full border bg-gray-100 grayscale">
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-600 leading-none mb-1">{{ $enrollment->student->name }} <span class="text-[10px] bg-gray-200 text-gray-500 rounded px-1">{{ strtoupper($enrollment->student->document_type) }} {{ $enrollment->student->document_number }}</span></p>
                                        <p class="text-[11px] text-gray-500">{{ $enrollment->student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                @if($enrollment->student->flagged_reason)
                                    <p class="text-xs italic text-gray-500 bg-gray-100 p-2 rounded-lg">"{{ $enrollment->student->flagged_reason }}"</p>
                                @else
                                    <p class="text-xs text-gray-400">Sin detalles</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('my-courses.restore', $enrollment) }}" class="restore-form inline-block">
                                    @csrf @method('PATCH')
                                    <button type="button" class="restore-btn text-xs font-bold text-mzl-teal bg-mzl-teal/10 hover:bg-mzl-teal hover:text-white px-3 py-1.5 rounded-lg transition-all focus:outline-none">
                                        Reintegrar Alumno
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- TAB 2: Actividades y Calificaciones --}}
        <div x-show="tab === 'actividades'" x-cloak x-transition.opacity.duration.300ms>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Panel Izquierdo: Crear Actividad --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-black text-gray-900 text-lg mb-4">Nueva Actividad</h3>
                        <form method="POST" action="{{ route('activities.store', $course) }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Título de la actividad *</label>
                                    <input type="text" name="title" required placeholder="Ej: Parcial 1, Taller final..." class="w-full rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 text-sm py-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nota Máxima *</label>
                                    <input type="number" name="max_grade" step="0.1" required value="5.0" class="w-full rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 text-sm py-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Descripción (opcional)</label>
                                    <textarea name="description" rows="2" class="w-full rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 text-sm py-2.5"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-mzl-blue text-white font-bold py-2.5 rounded-xl hover:bg-opacity-90 transition text-sm">
                                    Crear Actividad
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Panel Derecho: Lista de Actividades y Consolidado --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Lista de actividades --}}
                    @if($course->activities->isEmpty())
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                            <p class="text-gray-500 font-semibold mb-2">Este curso aún no tiene actividades evaluativas.</p>
                            <p class="text-xs text-gray-400">Crea una actividad en el panel izquierdo para comenzar a calificar a tus alumnos.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($course->activities as $activity)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-col hover:border-mzl-blue transition group">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-black text-gray-900 text-lg leading-tight">{{ $activity->title }}</h4>
                                    <form method="POST" action="{{ route('activities.destroy', [$course, $activity]) }}" onsubmit="return confirm('¿Seguro que deseas eliminar esta actividad y TODAS las calificaciones asociadas a ella? Esta acción no se puede deshacer.')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-300 hover:text-red-500 transition px-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                                <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $activity->description ?? 'Sin descripción' }}</p>
                                
                                <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400">Max: {{ $activity->max_grade }}</span>
                                    <a href="{{ route('speedgrader.show', [$course, $activity]) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-mzl-blue bg-mzl-blue/10 px-4 py-2 rounded-xl hover:bg-mzl-blue hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        SpeedGrader
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Consolidado Final (Gradebook) --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-6">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                                <h3 class="font-black text-gray-900">Libreta de Calificaciones (Consolidado)</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-white text-gray-400 font-bold border-b border-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 whitespace-nowrap">Estudiante</th>
                                            @foreach($course->activities as $activity)
                                                <th class="px-6 py-3 text-center whitespace-nowrap" title="{{ $activity->title }}">{{ \Illuminate\Support\Str::limit($activity->title, 15) }}</th>
                                            @endforeach
                                            <th class="px-6 py-3 text-center whitespace-nowrap bg-gray-50 text-gray-800">Promedio</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($activeEnrollments as $enrollment)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-3 font-semibold text-gray-700 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ $enrollment->student->avatarUrl() }}" class="w-6 h-6 rounded-full border">
                                                    {{ $enrollment->student->name }}
                                                </div>
                                            </td>
                                            
                                            @php 
                                                $totalScore = 0; 
                                                $gradedCount = 0;
                                            @endphp
                                            
                                            @foreach($course->activities as $activity)
                                                @php
                                                    $grade = $enrollment->grades->where('activity_id', $activity->id)->first();
                                                @endphp
                                                <td class="px-6 py-3 text-center">
                                                    @if($grade)
                                                        @php 
                                                            $totalScore += ($grade->score / $activity->max_grade) * 5; // Normalize to 5.0 base for average
                                                            $gradedCount++;
                                                        @endphp
                                                        <span class="font-bold {{ $grade->score >= ($activity->max_grade * 0.6) ? 'text-green-600' : 'text-mzl-pink' }}">
                                                            {{ floatval($grade->score) }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-300">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            
                                            <td class="px-6 py-3 text-center bg-gray-50 font-black">
                                                @if($gradedCount > 0)
                                                    @php $average = round($totalScore / $course->activities->count(), 1); @endphp
                                                    <span class="{{ $average >= 3.0 ? 'text-green-600' : 'text-mzl-pink' }}">{{ number_format($average, 1) }}</span>
                                                @else
                                                    <span class="text-gray-300">0.0</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.disable-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.disable-form');
            const commentInput = form.querySelector('.comment-input');
            
            Swal.fire({
                title: 'Inhabilitar Alumno',
                html: '<p class="text-sm text-gray-500 mb-3">La inscripción será cancelada, y su perfil quedará <b>marcado (flagged)</b> por abandono o mala conducta.</p>',
                input: 'textarea',
                inputLabel: 'Razón de la inhabilitación (obligatorio):',
                inputPlaceholder: 'Ej: No volvió a asistir a clases después de la primera semana...',
                inputAttributes: {
                    maxlength: 500,
                    required: true
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Sí, inhabilitar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'rounded-xl font-bold shadow-md',
                    cancelButton: 'rounded-xl font-bold border-0 hover:bg-gray-100',
                    input: 'rounded-xl border-gray-300 focus:ring-mzl-pink focus:border-mzl-pink'
                },
                inputValidator: (value) => {
                    if (!value || value.trim().length === 0) {
                        return 'Debes escribir una razón para inhabilitar al estudiante.'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    commentInput.value = result.value;
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.restore-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.restore-form');
            
            Swal.fire({
                title: 'Reintegrar Alumno',
                text: '¿Estás seguro que deseas deshacer la sanción y reintegrar a este alumno a tu curso? Se le devolverá su cupo.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0cb29c', // mzl-teal
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Sí, reintegrar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'rounded-xl font-bold shadow-md',
                    cancelButton: 'rounded-xl font-bold border-0 hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
