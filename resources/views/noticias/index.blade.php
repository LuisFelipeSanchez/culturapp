<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias y Actualidad — CulturApp Manizales</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app-noticias.tsx'])
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
<div class="bg-white border-b border-gray-200 overflow-hidden relative">
    {{-- Fondo decorativo --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] bg-gradient-to-l from-mzl-blue/[0.03] to-transparent transform rotate-12"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[100%] bg-gradient-to-r from-mzl-teal/[0.03] to-transparent transform -rotate-12"></div>
    </div>
    <div class="max-w-6xl mx-auto px-4 sm:px-8 py-10 lg:py-16 text-center relative z-10 animate-fade-in-up">
        <div class="inline-flex items-center gap-2 text-mzl-blue text-sm font-bold uppercase tracking-wider mb-4 bg-mzl-blue/10 px-4 py-1.5 rounded-full ring-4 ring-mzl-blue/5">
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

{{-- REACT STAGGER NEWS MOUNT POINT --}}
<div class="max-w-6xl mx-auto px-4 sm:px-8 py-10 lg:py-16">
    <div
        id="stagger-news-root"
        data-news='@json($news)'
    ></div>
</div>

</body>
</html>
