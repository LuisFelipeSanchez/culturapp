<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} — CulturApp Manizales</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<nav class="bg-white border-b border-gray-200 px-4 sm:px-8 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
    <a href="{{ route('sedes.show', $course->sede) }}" class="flex items-center gap-2 text-gray-500 hover:text-mzl-blue transition text-sm font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Volver a {{ $course->sede->name }}
    </a>
    <div class="flex items-center gap-3">
        @auth
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-mzl-blue hover:text-mzl-teal transition">Panel</a>
        @else
        <a href="{{ route('login') }}" class="text-sm font-bold bg-mzl-blue text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition">Ingresar para inscribirte</a>
        @endauth
    </div>
</nav>

<div class="bg-white border-b border-gray-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-8 py-10 lg:py-16">
        <div class="flex flex-col lg:flex-row gap-10 lg:items-start">
            
            <div class="w-full lg:w-5/12 shrink-0">
                <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-lg border border-gray-100 relative">
                    @if($course->image)
                        <img src="{{ asset('storage/'.$course->image) }}" alt="Foto de {{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-mzl-blue/20 to-mzl-teal/20 flex flex-col items-center justify-center text-gray-400 text-6xl">
                            {{ $course->category->icon ?? '🎨' }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <div>
                    <div class="flex items-center gap-2 text-mzl-blue text-sm font-bold uppercase tracking-wider mb-2">
                        <span>{{ $course->category->name }}</span>
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-500">{{ $course->sede->name }}</span>
                    </div>
                    <h1 class="font-black text-3xl lg:text-5xl text-gray-900 leading-tight">{{ $course->title }}</h1>
                </div>

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

                <p class="text-gray-600 text-lg leading-relaxed">{{ $course->description }}</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="col-span-2">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Horarios</p>
                        <p class="text-sm font-bold text-gray-800">{{ $course->formatted_schedule }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Duración</p>
                        <p class="text-sm font-bold text-gray-800">{{ $course->hours }} horas</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Fechas</p>
                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Cupos Disp.</p>
                        <p class="text-sm font-black {{ $course->availableSpots > 0 ? 'text-mzl-blue' : 'text-mzl-pink' }}">{{ $course->availableSpots }} / {{ $course->capacity }}</p>
                    </div>
                </div>

                @if(isset($course->managers) && $course->managers->count() > 0)
                <div>
                    <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Profesores / Encargados</h3>
                    <div class="flex flex-wrap gap-4">
                        @foreach($course->managers as $manager)
                        <div class="flex items-center gap-3">
                            <img src="{{ $manager->avatarUrl() }}" alt="" class="w-10 h-10 rounded-full border border-gray-200">
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $manager->name }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="pt-4">
                    @auth
                        @php
                            $enrollment = $course->enrollments()->where('user_id', auth()->id())->first();
                        @endphp
                        
                        @if($enrollment)
                            @if(in_array($enrollment->status, ['enrolled', 'pending']))
                                <form id="unenroll-form" method="POST" action="{{ route('enrollments.destroy', $course) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-mzl-pink text-mzl-pink rounded-2xl font-black shadow-sm text-lg hover:bg-mzl-pink hover:text-white transition-all flex items-center justify-center gap-2">
                                        Anular mi inscripción
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            @elseif($enrollment->status === 'approved')
                                <form id="unenroll-form" method="POST" action="{{ route('enrollments.destroy', $course) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-mzl-pink text-mzl-pink rounded-2xl font-black shadow-sm text-lg hover:bg-mzl-pink hover:text-white transition-all flex items-center justify-center gap-2">
                                        Anular mi inscripción
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            @elseif(in_array($enrollment->status, ['failed', 'dropped']))
                                <button disabled class="w-full sm:w-auto px-8 py-4 bg-mzl-pink/10 text-mzl-pink rounded-2xl font-black shadow-sm text-lg flex items-center justify-center gap-2 cursor-not-allowed border border-mzl-pink/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    Inscripción anulada/inhabilitada
                                </button>
                            @endif
                        @elseif($course->availableSpots <= 0)
                            <button disabled class="w-full sm:w-auto px-8 py-4 bg-mzl-black/10 text-gray-500 rounded-2xl font-black shadow-sm text-lg flex items-center justify-center gap-2 cursor-not-allowed border border-gray-200">
                                Cupos agotados
                            </button>
                        @else
                            <form method="POST" action="{{ route('enrollments.store', $course) }}">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-mzl-blue text-white rounded-2xl font-black shadow-lg shadow-mzl-blue/30 text-lg hover:-translate-y-1 hover:shadow-xl hover:shadow-mzl-blue/40 transition-all flex items-center justify-center gap-2">
                                    ¡Inscribirme ahora!
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex w-full sm:w-auto px-8 py-4 bg-gray-900 text-white rounded-2xl font-black shadow-lg text-lg hover:-translate-y-1 transition-all items-center justify-center gap-2">
                            Inicia sesión para inscribirte
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</div>

<div class="flex h-1.5 w-full">
    <div class="flex-1 bg-mzl-blue"></div><div class="flex-1 bg-mzl-teal"></div><div class="flex-1 bg-mzl-orange"></div><div class="flex-1 bg-mzl-pink"></div><div class="flex-1 bg-mzl-yellow"></div>
</div>

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const unenrollForm = document.getElementById('unenroll-form');
    if (unenrollForm) {
        unenrollForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Procederemos a anular tu inscripción a este curso. Esta acción liberará tu cupo.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Sí, anular inscripción',
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

</html>
