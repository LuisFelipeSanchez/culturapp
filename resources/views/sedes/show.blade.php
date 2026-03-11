<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sede->name }} — CulturApp Manizales</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- NAV --}}
<nav class="bg-white border-b border-gray-200 px-4 sm:px-8 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
    <a href="{{ route('sedes.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-mzl-blue transition text-sm font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Todas las sedes
    </a>
    <div class="flex items-center gap-3">
        <div class="hidden sm:flex gap-1.5 mr-4">
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-blue"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-teal"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-orange"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-pink"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-yellow"></span>
        </div>

        <a href="{{ route('noticias.index') }}" class="text-sm font-bold text-gray-500 hover:text-mzl-blue transition hidden sm:block">Noticias Locales</a>
        @auth
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-mzl-blue hover:text-mzl-teal transition">Panel</a>
        @else
        <a href="{{ route('login') }}" class="text-sm font-bold bg-mzl-blue text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition">Ingresar</a>
        @endauth
    </div>
</nav>

{{-- ALPINE WRAPPER para las pestañas --}}
<div x-data="{ tab: 'inicio' }">

    {{-- HERO MODULAR: Foto, Título, Descripción --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-8 py-10 lg:py-16">
            <div class="flex flex-col lg:flex-row gap-10 lg:items-center">
                
                {{-- Foto principal de la sede --}}
                <div class="w-full lg:w-5/12 shrink-0">
                    <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-lg border border-gray-100 relative group">
                        @if($sede->image_url)
                            <img src="{{ $sede->image_url }}" alt="Foto de {{ $sede->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-mzl-blue/20 to-mzl-teal/20 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-sm font-medium">Sin imagen</span>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-xs font-bold shadow-sm uppercase tracking-wide 
                                {{ $sede->zone === 'urbana' ? 'text-mzl-blue' : 'text-mzl-teal' }}">
                                Zona {{ $sede->zone }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Información y Descripción --}}
                <div class="flex-1">
                    <div class="flex items-center gap-2 text-mzl-blue text-sm font-bold uppercase tracking-wider mb-2">
                        <span>Casas de la Cultura</span>
                        <span class="text-gray-300">•</span>
                        <span class="text-gray-500">{{ $sede->zone === 'urbana' ? 'Ciudad' : 'Veredas' }}</span>
                    </div>
                    <h1 class="font-black text-4xl lg:text-5xl text-gray-900 leading-tight mb-4 group">{{ $sede->name }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-y-2 gap-x-3 text-gray-500 text-sm mb-6">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $sede->address }}</span>
                        </div>
                        
                        @if(is_array($sede->contact_info))
                            @if(!empty($sede->contact_info['telefono']))
                                <span class="hidden sm:inline text-gray-300">•</span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $sede->contact_info['telefono'] }}</span>
                                </div>
                            @endif

                            @if(!empty($sede->contact_info['whatsapp']))
                                <span class="hidden sm:inline text-gray-300">•</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sede->contact_info['whatsapp']) }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 text-green-600 hover:text-green-700 transition font-semibold">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                    <span>{{ $sede->contact_info['whatsapp'] }}</span>
                                </a>
                            @endif

                            @if(!empty($sede->contact_info['instagram']))
                                <span class="hidden sm:inline text-gray-300">•</span>
                                <a href="{{ Str::startsWith($sede->contact_info['instagram'], 'http') ? $sede->contact_info['instagram'] : 'https://'.$sede->contact_info['instagram'] }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-1.5 text-pink-600 hover:text-pink-700 transition font-semibold">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                    <span>Instagram</span>
                                </a>
                            @endif
                        @endif
                    </div>

                    @if($sede->description)
                        <p class="text-gray-600 text-lg leading-relaxed mb-8">{{ $sede->description }}</p>
                    @endif

                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <p class="font-black text-2xl text-gray-900">{{ $sede->news->count() }}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Noticias</p>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="text-center">
                            <p class="font-black text-2xl text-mzl-blue">{{ $sede->courses->count() }}</p>
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold">Cursos</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Barra de Colores del Hero --}}
    <div class="flex h-1.5 w-full">
        <div class="flex-1 bg-mzl-blue"></div><div class="flex-1 bg-mzl-teal"></div><div class="flex-1 bg-mzl-orange"></div><div class="flex-1 bg-mzl-pink"></div><div class="flex-1 bg-mzl-yellow"></div>
    </div>

    {{-- CONTENT WRAPPER --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-8 py-10">

        {{-- COOL TOGGLE (Burbuja animada) --}}
        <div class="flex justify-center mb-10">
            <div class="relative flex items-center p-1 bg-gray-200/60 rounded-full shadow-inner border border-gray-200/50">
                {{-- Burbuja azul de fondo (animada) --}}
                <div class="absolute inset-y-1 w-1/2 bg-mzl-blue rounded-full shadow transition-transform duration-300 cubic-bezier(0.4, 0, 0.2, 1)"
                     :class="tab === 'inicio' ? 'translate-x-0' : 'translate-x-[calc(100%-2px)]'">
                </div>
                
                {{-- Botones frontales --}}
                <button @click="tab = 'inicio'" 
                        class="relative z-10 w-40 py-2.5 text-sm font-black uppercase tracking-wider transition-colors duration-300 rounded-full"
                        :class="tab === 'inicio' ? 'text-white' : 'text-gray-500 hover:text-gray-700'">
                    Inicio
                </button>
                <button @click="tab = 'cursos'" 
                        class="relative z-10 w-40 py-2.5 text-sm font-black uppercase tracking-wider transition-colors duration-300 rounded-full"
                        :class="tab === 'cursos' ? 'text-white' : 'text-gray-500 hover:text-gray-700'">
                    Cursos
                </button>
            </div>
        </div>

        {{-- TAB: INICIO (Noticias) --}}
        <div x-show="tab === 'inicio'" x-transition.opacity.duration.400ms x-cloak>
            <h2 class="font-black text-2xl text-gray-900 mb-6">Noticias y Actualidad</h2>
            
            @if($sede->news->isEmpty())
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"/></svg>
                <p class="font-bold text-lg text-gray-500 mb-1">Cero noticias por ahora</p>
                <p class="text-sm">Vuelve pronto para enterarte de lo que pasa en esta sede.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($sede->news as $item)
                <article class="bg-white rounded-3xl shadow-sm hover:shadow-md border border-gray-100 transition duration-300 flex flex-col overflow-hidden group/news">
                    <div class="p-6 md:p-8 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-mzl-orange"></span>
                            {{ $item->created_at->translatedFormat('d F Y') }}
                        </div>
                        <h3 class="font-black text-xl text-gray-900 group-hover/news:text-mzl-blue transition leading-snug mb-3">
                            {{ $item->title }}
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed flex-1">
                            {{ $item->body ?? $item->content }}
                        </p>
                    </div>

                    {{-- Acción de la noticia si existe --}}
                    @if($item->action_url && $item->action_text)
                    <div class="p-6 pt-0 mt-auto">
                        <a href="{{ $item->action_url }}" class="inline-flex items-center justify-center gap-2 w-full lg:w-auto px-6 py-2.5 bg-gray-50 hover:bg-mzl-blue text-mzl-blue hover:text-white rounded-xl font-bold text-sm transition-colors border border-gray-100 hover:border-mzl-blue group/btn">
                            {{ $item->action_text }}
                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                    @endisset
                </article>
                @endforeach
            </div>
            @endif
        </div>

        {{-- TAB: CURSOS --}}
        <div x-show="tab === 'cursos'" x-transition.opacity.duration.400ms x-cloak>
            <h2 class="font-black text-2xl text-gray-900 mb-6">Oferta de Cursos</h2>
            
            @if($sede->courses->isEmpty())
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <p class="font-bold text-lg text-gray-500 mb-1">Sin cursos todavía</p>
                <p class="text-sm">Actualmente no hay inscripciones abiertas para esta sede.</p>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sede->courses as $course)
                @php
                    $statusColors = match($course->status) {
                        'open'        => ['bg-mzl-teal/10', 'text-mzl-teal', 'border-mzl-teal/20', 'Abierto'],
                        'in_progress' => ['bg-mzl-orange/10', 'text-mzl-orange', 'border-mzl-orange/20', 'En progreso'],
                        'finished'    => ['bg-gray-100', 'text-gray-500', 'border-gray-200', 'Finalizado'],
                        'cancelled'   => ['bg-mzl-pink/10', 'text-mzl-pink', 'border-mzl-pink/20', 'Cancelado'],
                        default       => ['bg-gray-100', 'text-gray-500', 'border-gray-200', $course->status],
                    };
                @endphp
                <div class="bg-white rounded-3xl shadow-sm hover:shadow-lg border border-gray-100 transition-all duration-300 overflow-hidden group cursor-default flex flex-col">
                    <div class="relative w-full h-40 overflow-hidden">
                        @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-50 flex items-center justify-center text-5xl">
                            {{ $course->category->icon ?? '🎨' }}
                        </div>
                        @endif
                        <div class="absolute top-3 right-3 flex gap-2">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider backdrop-blur bg-white/90 shadow-sm border {{ $statusColors[2] }} {{ $statusColors[1] }}">
                                {{ $statusColors[3] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-1.5 mb-2">
                            <span class="text-sm font-mzl-blue leading-none">{{ $course->category->icon ?? '' }}</span>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $course->category->name }}</span>
                        </div>
                        <h3 class="font-black text-lg text-gray-900 leading-snug mb-4 group-hover:text-mzl-blue transition-colors">
                            {{ $course->title }}
                        </h3>
                        
                        <div class="mt-auto space-y-2.5">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>{{ \Carbon\Carbon::parse($course->start_date)->translatedFormat('d M') }} — {{ \Carbon\Carbon::parse($course->end_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $course->schedule }} </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                                <span>{{ $course->hours }} horas totales • {{ $course->capacity }} cupos</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>

</div>

</body>
</html>
