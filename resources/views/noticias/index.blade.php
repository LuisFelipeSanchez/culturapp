<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias y Actualidad — CulturApp Manizales</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

{{-- NAV --}}
<nav class="bg-white border-b border-gray-200 px-4 sm:px-8 py-3 flex items-center justify-between shadow-sm sticky top-0 z-20">
    <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-500 hover:text-mzl-blue transition text-sm font-semibold">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Inicio
    </a>
    <div class="flex items-center gap-3">
        <div class="hidden sm:flex gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-blue"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-teal"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-orange"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-pink"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-yellow"></span>
        </div>
        @auth
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-mzl-blue hover:text-mzl-teal transition">Panel</a>
        @else
        <a href="{{ route('login') }}" class="text-sm font-bold bg-mzl-blue text-white px-4 py-2 rounded-xl hover:bg-opacity-90 transition">Ingresar</a>
        @endauth
    </div>
</nav>

{{-- HERO GLOBAL NEWS --}}
<div class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-8 py-10 lg:py-16 text-center">
        <div class="inline-flex items-center gap-2 text-mzl-blue text-sm font-bold uppercase tracking-wider mb-4 bg-mzl-blue/10 px-4 py-1.5 rounded-full">
            <span>Secretaría de Cultura de Manizales</span>
        </div>
        <h1 class="font-black text-4xl lg:text-5xl text-gray-900 leading-tight mb-4">Actualidad Cultural</h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-2xl mx-auto">
            Descubre los eventos globales, convocatorias municipales y reportes generales de impacto cultural que conectan a nuestra ciudad.
        </p>
    </div>
</div>
{{-- Barra de Colores del Hero --}}
<div class="flex h-1.5 w-full">
    <div class="flex-1 bg-mzl-blue"></div><div class="flex-1 bg-mzl-teal"></div><div class="flex-1 bg-mzl-orange"></div><div class="flex-1 bg-mzl-pink"></div><div class="flex-1 bg-mzl-yellow"></div>
</div>

{{-- GLOBAL NEWS GRID --}}
<div class="max-w-6xl mx-auto px-4 sm:px-8 py-10 lg:py-16">
    @if($news->isEmpty())
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"/></svg>
            <p class="font-bold text-lg text-gray-500 mb-1">Cero anuncios por ahora</p>
            <p class="text-sm">Vuelve pronto para enterarte de lo que pasa a nivel ciudad.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
            <article class="bg-white rounded-3xl shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 flex flex-col overflow-hidden group">
                
                @if($item->image_url)
                <div class="relative w-full h-48 overflow-hidden">
                    <img src="{{ Str::startsWith($item->image_url, 'http') ? $item->image_url : asset($item->image_url) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                
                <div class="p-6 md:p-8 flex-1 flex flex-col">
                    <div class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-mzl-yellow"></span>
                        {{ $item->created_at->translatedFormat('d F Y') }}
                    </div>
                    <h3 class="font-black text-xl text-gray-900 group-hover:text-mzl-blue transition leading-snug mb-3">
                        {{ $item->title }}
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed flex-1">
                        {{ $item->body ?? $item->content }}
                    </p>
                </div>

                {{-- Acción de la noticia si existe --}}
                @if($item->action_url && $item->action_text)
                <div class="p-6 pt-0 mt-auto">
                    <a href="{{ $item->action_url }}" class="inline-flex items-center justify-center gap-2 w-full px-6 py-2.5 bg-gray-50 hover:bg-mzl-blue text-mzl-blue hover:text-white rounded-xl font-bold text-sm transition-colors border border-gray-100 hover:border-mzl-blue group/btn">
                        {{ $item->action_text }}
                        <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                @endisset
            </article>
            @endforeach
        </div>

        @if($news->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $news->links() }}
        </div>
        @endif
    @endif
</div>

</body>
</html>
