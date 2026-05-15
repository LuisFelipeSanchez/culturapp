@extends('layouts.app')

@section('content')
@php
    $statusBadge = match($course->status) {
        'open'        => ['label' => 'Abierto',      'class' => 'bg-mzl-teal/10 text-mzl-teal'],
        'in_progress' => ['label' => 'En progreso',  'class' => 'bg-mzl-orange/10 text-mzl-orange'],
        'finished'    => ['label' => 'Finalizado',   'class' => 'bg-gray-100 text-gray-500'],
        'cancelled'   => ['label' => 'Cancelado',    'class' => 'bg-mzl-pink/10 text-mzl-pink'],
        default       => ['label' => $course->status,'class' => 'bg-gray-100 text-gray-500'],
    };
@endphp
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-8 py-10">
        <div class="max-w-4xl mx-auto flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-white/60 text-xs mb-2">
                    <a href="{{ route('admin.cursos.index') }}" class="hover:text-white transition">Cursos</a>
                    <span>/</span>
                    <span class="text-white">{{ $course->title }}</span>
                </div>
                <h1 class="text-white text-3xl font-black">{{ $course->title }}</h1>
                <div class="flex flex-wrap items-center gap-3 mt-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusBadge['class'] }} bg-white/10 text-white/80">
                        {{ $statusBadge['label'] }}
                    </span>
                    <span class="text-white/60 text-sm">{{ $course->category->icon ?? '' }} {{ $course->category->name }}</span>
                    <span class="text-white/60 text-sm">📍 {{ $course->sede->name }}</span>
                </div>
            </div>
            <div class="flex gap-2 self-start sm:self-auto">
                <a href="{{ route('admin.cursos.edit', $course) }}"
                   class="inline-flex items-center gap-2 bg-white text-mzl-blue font-bold px-4 py-2 rounded-xl text-sm shadow hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
                <form id="delete-course-form" method="POST" action="{{ route('admin.cursos.destroy', $course) }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-white/10 text-white border border-white/20 font-bold px-4 py-2 rounded-xl text-sm hover:bg-mzl-pink/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-8 mt-8 space-y-6">

        @if(session('success'))
        <div class="bg-mzl-teal/10 border border-mzl-teal rounded-2xl p-4 flex items-center gap-3 text-mzl-teal text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-mzl-pink/10 border border-mzl-pink rounded-2xl p-4 text-mzl-pink text-sm font-semibold">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Info principal --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm p-6 space-y-4">
                    <h2 class="font-bold text-gray-900">Descripción</h2>

                    {{-- Imagen flotante a la derecha --}}
                    @if($course->image)
                    <div class="float-right ml-5 mb-3">
                        <img src="{{ $course->image_url }}"
                             alt="{{ $course->title }}"
                             class="w-40 h-40 object-cover rounded-2xl shadow-md border border-gray-100">
                    </div>
                    @endif

                    <p class="text-gray-600 text-sm leading-relaxed">{{ $course->description }}</p>
                    <div class="clear-both"></div>

                    <hr class="border-gray-100">

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-1">Horario de Clases</p>
                        <p class="text-sm font-semibold text-gray-900 border border-gray-200 rounded-lg px-3 py-2 bg-white">{{ $course->formatted_schedule }}</p>
                    </div>
                        <div>
                            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Cupo máximo</p>
                            <p class="text-gray-800 font-semibold">{{ $course->capacity }} estudiantes</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Fecha inicio</p>
                            <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs font-semibold uppercase tracking-wide mb-1">Fecha fin</p>
                            <p class="text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Inscripciones --}}
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-gray-900">Inscritos</h2>
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-mzl-blue/10 text-mzl-blue">
                            {{ $course->enrollments->count() }} / {{ $course->capacity }}
                        </span>
                    </div>
                    {{-- Barra de progreso de cupo --}}
                    <div class="px-6 pt-4">
                        @php $pct = $course->capacity > 0 ? min(100, round($course->enrollments->count() / $course->capacity * 100)) : 0; @endphp
                        <div class="flex justify-between text-xs text-gray-400 mb-1">
                            <span>Ocupación</span>
                            <span>{{ $pct }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500
                                {{ $pct >= 90 ? 'bg-mzl-pink' : ($pct >= 60 ? 'bg-mzl-orange' : 'bg-mzl-teal') }}"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    <ul class="divide-y divide-gray-50 mt-3">
                        @forelse($course->enrollments as $enrollment)
                        <li class="px-6 py-3 flex items-center gap-3 hover:bg-gray-50 transition rounded-xl">
                            <img src="{{ $enrollment->student->avatarUrl() }}"
                                 alt="{{ $enrollment->student->name }}"
                                 class="w-8 h-8 rounded-full object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $enrollment->student->name }}</p>
                                <p class="text-xs text-gray-400">{{ $enrollment->student->email }}</p>
                            </div>
                            
                            <div class="flex items-center gap-3 shrink-0">
                                @php
                                    $gradesCount  = $enrollment->grades->count();
                                    $calcAverage  = $gradesCount > 0 ? $enrollment->grades->avg('score') : null;
                                    $totalActs    = $course->activities->count();
                                @endphp

                                @if($calcAverage !== null)
                                    <div class="text-right">
                                        <span class="text-xs font-bold {{ $calcAverage >= 3.5 ? 'text-mzl-teal' : 'text-mzl-pink' }}">
                                            Promedio: {{ number_format($calcAverage, 1) }}
                                        </span>
                                        <p class="text-[10px] text-gray-400 leading-none mt-0.5">{{ $gradesCount }}/{{ $totalActs }} evaluadas</p>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Sin evaluar</span>
                                @endif
                                
                                <a href="{{ route('admin.cursos.certificado', ['course' => $course->id, 'user' => $enrollment->student->id]) }}" 
                                   title="Generar Certificado Individual" 
                                   class="p-1.5 border-2 border-gray-100 text-mzl-teal rounded-lg hover:bg-mzl-teal hover:text-white hover:border-mzl-teal transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                                </a>
                            </div>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-gray-400 text-sm">Aún no hay inscritos.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Sidebar info --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm p-5 space-y-4">
                    <h2 class="font-bold text-gray-900 text-sm">Sede</h2>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $course->sede->name }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">{{ $course->sede->address }}</p>
                        <span class="inline-block mt-2 px-2.5 py-1 rounded-full text-xs font-bold
                            {{ $course->sede->zone === 'urbana' ? 'bg-mzl-blue/10 text-mzl-blue' : 'bg-mzl-orange/10 text-mzl-orange' }}">
                            {{ ucfirst($course->sede->zone) }}
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-5 space-y-4">
                    <h2 class="font-bold text-gray-900 text-sm">Encargados / Profesores</h2>
                    @if(isset($course->managers) && $course->managers->count() > 0)
                        <ul class="space-y-3 mt-3">
                            @foreach($course->managers as $manager)
                            <li class="flex items-center gap-3">
                                <img src="{{ $manager->avatarUrl() }}" alt="" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $manager->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $manager->email }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-400">No hay encargados asignados.</p>
                    @endif
                </div>

                <div class="flex h-2 rounded-full overflow-hidden shadow-sm">
                    <div class="flex-1 bg-mzl-blue"></div>
                    <div class="flex-1 bg-mzl-teal"></div>
                    <div class="flex-1 bg-mzl-orange"></div>
                    <div class="flex-1 bg-mzl-pink"></div>
                    <div class="flex-1 bg-mzl-yellow"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const deleteForm = document.getElementById('delete-course-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Confirmar eliminación?',
                text: "Esta acción es irreversible y eliminará todos los registros asociados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Sí, eliminar curso',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'rounded-xl font-bold shadow-md',
                    cancelButton: 'rounded-xl font-bold border-0 hover:bg-gray-100'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }
</script>
@endpush
