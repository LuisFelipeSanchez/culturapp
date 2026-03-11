@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12">

    {{-- ===== HEADER LIMPIO (sin SVG) ===== --}}
    <div class="bg-gradient-to-r from-[#1a1f3e] via-mzl-blue to-mzl-teal px-4 sm:px-6 lg:px-8 py-10">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-white/60 text-xs font-bold uppercase tracking-widest">CulturApp Manizales</p>
                <h1 class="text-white text-3xl sm:text-4xl font-black mt-1">
                    ¡Hola, {{ Auth::user()->name }}!
                </h1>
                <p class="text-white/70 mt-1 text-sm">
                    {{ Auth::user()->isSuperAdmin() ? 'Panel Global' : (Auth::user()->isAdmin() ? 'Panel de Administración' : 'Mi Portal') }}
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                <a href="{{ route('admin.manage') }}"
                   class="inline-flex items-center gap-2 bg-white text-mzl-blue font-bold px-5 py-2.5 rounded-xl shadow hover:bg-gray-50 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Gestionar Sedes
                </a>
                @endif
                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center gap-2 bg-white/10 text-white border border-white/30 font-bold px-5 py-2.5 rounded-xl hover:bg-white/20 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Mi Perfil
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 space-y-8">

        {{-- ===== KPIs ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
            <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-mzl-blue">
                <div class="bg-mzl-blue/10 p-3 rounded-xl shrink-0">
                    <svg class="w-6 h-6 text-mzl-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $totalSedes }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Sedes</p>
                </div>
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-mzl-teal">
                <div class="bg-mzl-teal/10 p-3 rounded-xl shrink-0">
                    <svg class="w-6 h-6 text-mzl-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $totalCourses }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">{{ Auth::user()->isCitizen() ? 'Cursos Disponibles' : 'Cursos' }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-mzl-orange">
                <div class="bg-mzl-orange/10 p-3 rounded-xl shrink-0">
                    <svg class="w-6 h-6 text-mzl-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $totalEnrollments }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">{{ Auth::user()->isCitizen() ? 'Mis Inscripciones' : 'Inscritos' }}</p>
                </div>
            </div>
            @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
            <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border-l-4 border-mzl-pink">
                <div class="bg-mzl-pink/10 p-3 rounded-xl shrink-0">
                    <svg class="w-6 h-6 text-mzl-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-gray-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide">Usuarios</p>
                </div>
            </div>
            @endif
        </div>

        {{-- ===== ALERTAS ===== --}}
        @if($pendingGrades > 0 || $fullCourses > 0)
        <div>
            <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Acciones pendientes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @if($pendingGrades > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 flex items-start gap-3">
                    <div class="bg-yellow-100 p-2 rounded-lg mt-0.5 shrink-0">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-yellow-800">{{ $pendingGrades }} notas sin asignar</p>
                        <p class="text-yellow-700 text-sm mt-0.5">Hay inscripciones sin calificación final.</p>
                    </div>
                </div>
                @endif
                @if($fullCourses > 0)
                <div class="bg-pink-50 border border-pink-200 rounded-2xl p-5 flex items-start gap-3">
                    <div class="bg-pink-100 p-2 rounded-lg mt-0.5 shrink-0">
                        <svg class="w-5 h-5 text-mzl-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </div>
                    <div>
                        <p class="font-bold text-mzl-pink">{{ $fullCourses }} cursos sin cupo</p>
                        <p class="text-pink-700 text-sm mt-0.5">Algunos cursos alcanzaron su capacidad máxima.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- ===== CAROUSEL DE SEDES ===== --}}
        @php
            // Imagenes de placeholder culturales via Unsplash
            $sedeImages = [
                'https://images.unsplash.com/photo-1569388033990-f84c1e2de7df?w=800&q=80', // teatro/cultura
                'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?w=800&q=80', // artes
                'https://images.unsplash.com/photo-1541753866388-0b3c701627d3?w=800&q=80', // danza
                'https://images.unsplash.com/photo-1522158637959-30385a09e0da?w=800&q=80', // musica
                'https://images.unsplash.com/photo-1635003913011-95671e37c273?w=800&q=80', // pintura
                'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800&q=80', // espectaculo
            ];
        @endphp

        @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Sedes</h2>
                <a href="{{ route('admin.manage') }}" class="text-mzl-blue text-sm font-semibold hover:underline">Ver todas →</a>
            </div>

            {{-- Alpine carousel --}}
            <div
                x-data="{
                    current: 0,
                    total: {{ $sedes->count() }},
                    timer: null,
                    perPage: window.innerWidth >= 1024 ? 3 : window.innerWidth >= 640 ? 2 : 1,
                    get maxSlide() { return Math.max(0, this.total - this.perPage); },
                    prev() { this.current = Math.max(0, this.current - 1); },
                    next() { this.current = this.current >= this.maxSlide ? 0 : this.current + 1; },
                    startAuto() {
                        if (window.innerWidth >= 768) {
                            this.timer = setInterval(() => this.next(), 2500);
                        }
                    },
                    stopAuto() {
                        clearInterval(this.timer);
                    },
                    init() {
                        this.startAuto();
                        window.addEventListener('resize', () => {
                            this.perPage = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 640 ? 2 : 1;
                            this.current = Math.min(this.current, this.maxSlide);
                        });
                    }
                }"
                @mouseenter="stopAuto()"
                @mouseleave="startAuto()"
                class="relative"
            >
                {{-- Track --}}
                <style>
                    .no-scrollbar::-webkit-scrollbar { display: none; }
                    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                </style>
                <div class="md:overflow-hidden overflow-x-auto snap-x snap-mandatory no-scrollbar pb-4 md:pb-0 -mb-4 md:mb-0">
                    <div
                        class="flex md:transition-transform md:duration-500 md:ease-in-out gap-5"
                        :style="window.innerWidth >= 768 ? `transform: translateX(calc(-${current * (100 / perPage)}% - ${current * (20 / perPage)}px))` : ''"
                    >
                        @foreach($sedes as $index => $sede)
                        @php
                            $img = $sedeImages[$index % count($sedeImages)];
                        @endphp
                        <div class="shrink-0 w-[85%] sm:w-[calc(50%-10px)] lg:w-[calc(33.333%-14px)] snap-center">
                            <div class="relative rounded-3xl overflow-hidden shadow-lg group h-80 cursor-pointer">
                                {{-- Foto de fondo --}}
                                <img
                                    src="{{ $img }}"
                                    alt="{{ $sede->name }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                >
                                {{-- Gradiente oscuro base --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                {{-- Panel de info con backdrop-blur --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5">
                                    <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-4">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-white font-black text-lg leading-tight truncate">{{ $sede->name }}</p>
                                                <p class="text-white/70 text-xs mt-0.5 truncate">{{ $sede->address }}</p>
                                            </div>
                                            <span class="shrink-0 px-2 py-1 rounded-full text-xs font-bold
                                                {{ $sede->zone === 'urbana' ? 'bg-mzl-blue text-white' : 'bg-mzl-orange text-white' }}">
                                                {{ ucfirst($sede->zone) }}
                                            </span>
                                        </div>
                                        {{-- Stats en fila --}}
                                        <div class="flex gap-4 mt-3">
                                            <div class="text-center">
                                                <p class="text-white font-black text-lg leading-none">{{ $sede->courses_count }}</p>
                                                <p class="text-white/60 text-[10px] uppercase tracking-wide">Cursos</p>
                                            </div>
                                            <div class="w-px bg-white/20"></div>
                                            <div class="text-center">
                                                <p class="text-white font-black text-lg leading-none">{{ $sede->total_enrollments }}</p>
                                                <p class="text-white/60 text-[10px] uppercase tracking-wide">Inscritos</p>
                                            </div>
                                            <div class="w-px bg-white/20"></div>
                                            <div class="text-center">
                                                <p class="text-white font-black text-lg leading-none">{{ $sede->news_count }}</p>
                                                <p class="text-white/60 text-[10px] uppercase tracking-wide">Noticias</p>
                                            </div>
                                            <div class="flex-1 flex items-center justify-end">
                                                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                                                <a href="{{ route('admin.manage', $sede->id) }}"
                                                   class="text-xs font-bold text-mzl-yellow hover:text-white transition">
                                                    Gestionar →
                                                </a>
                                                @else
                                                <a href="{{ route('sedes.show', $sede->id) }}"
                                                   class="text-xs font-bold text-mzl-teal hover:text-white transition">
                                                    Ver Sede →
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Controles (solo desktop) --}}
                <div class="hidden md:flex items-center justify-between mt-5">
                    {{-- Dots --}}
                    <div class="flex gap-2">
                        @foreach($sedes as $index => $sede)
                        <button
                            @click="current = {{ $index }} <= maxSlide ? {{ $index }} : maxSlide"
                            :class="{{ $index }} === current ? 'bg-mzl-blue w-6' : 'bg-gray-300 w-2.5'"
                            class="h-2.5 rounded-full transition-all duration-300"
                        ></button>
                        @endforeach
                    </div>
                    {{-- Flechas --}}
                    <div class="flex gap-2">
                        <button @click="prev"
                            :disabled="current === 0"
                            :class="current === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-mzl-blue hover:text-white hover:border-mzl-blue'"
                            class="w-10 h-10 rounded-full border-2 border-gray-300 text-gray-500 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next"
                            :disabled="current >= maxSlide"
                            :class="current >= maxSlide ? 'opacity-30 cursor-not-allowed' : 'hover:bg-mzl-blue hover:text-white hover:border-mzl-blue'"
                            class="w-10 h-10 rounded-full border-2 border-gray-300 text-gray-500 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ===== GRID INFERIOR: últimas inscripciones + quick actions ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Últimas inscripciones --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-bold text-gray-900">
                        {{ Auth::user()->isCitizen() ? 'Mis cursos recientes' : 'Últimas inscripciones' }}
                    </h2>
                </div>
                <ul class="divide-y divide-gray-50">
                    @forelse($recentEnrollments as $enrollment)
                    <li class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-mzl-blue to-mzl-teal flex items-center justify-center text-white font-black text-sm shrink-0">
                            {{ strtoupper(substr($enrollment->student->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $enrollment->student->name ?? 'Usuario' }}</p>
                            <p class="text-gray-500 text-xs truncate">{{ $enrollment->course->title ?? 'Curso' }}</p>
                        </div>
                        <p class="text-gray-400 text-xs shrink-0">{{ $enrollment->created_at->diffForHumans() }}</p>
                    </li>
                    @empty
                    <li class="px-6 py-10 text-center text-gray-400 text-sm">Ninguna inscripción reciente.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Acciones rápidas --}}
            <div class="flex flex-col gap-4">
                <h2 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Acciones rápidas</h2>
                
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                    <a href="{{ route('admin.manage') }}" class="bg-mzl-blue text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>
                        <span class="font-bold">Gestionar Sedes</span>
                    </a>
                    <a href="{{ route('admin.cursos.create') }}" class="bg-mzl-teal text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg></div>
                        <span class="font-bold">Nuevo Curso</span>
                    </a>
                    <a href="{{ route('admin.cursos.index') }}" class="bg-mzl-orange text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg></div>
                        <span class="font-bold">Ver Inscripciones</span>
                    </a>
                    <a href="{{ route('admin.noticias.create') }}" class="bg-mzl-pink text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg></div>
                        <span class="font-bold">Publicar Noticia</span>
                    </a>
                @else
                    <a href="{{ route('sedes.index') }}" class="bg-mzl-blue text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>
                        <span class="font-bold">Explorar Sedes</span>
                    </a>
                    <a href="{{ route('noticias.index') }}" class="bg-mzl-pink text-white rounded-2xl p-5 flex items-center gap-4 hover:bg-opacity-90 transition shadow-sm">
                        <div class="bg-white/20 p-2 rounded-xl"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg></div>
                        <span class="font-bold">Noticias Culturales</span>
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
