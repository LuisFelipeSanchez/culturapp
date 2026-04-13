<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CulturApp') }}{{ isset($pageTitle) ? ' — ' . $pageTitle : '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Nunito', sans-serif; }

            /* Animación suave de los elementos del SVG */
            .svg-float-1 { animation: floatUp 8s ease-in-out infinite; }
            .svg-float-2 { animation: floatUp 11s ease-in-out infinite reverse; }
            .svg-float-3 { animation: floatUp 9s ease-in-out infinite 2s; }

            @keyframes floatUp {
                0%, 100% { transform: translateY(0px); }
                50%       { transform: translateY(-18px); }
            }

            /* Wavy path subtle motion */
            .svg-wave { animation: waveSway 12s ease-in-out infinite; transform-origin: center bottom; }
            @keyframes waveSway {
                0%, 100% { transform: scaleX(1) translateX(0); }
                50%       { transform: scaleX(1.03) translateX(-10px); }
            }
        </style>
    </head>
    <body class="antialiased min-h-screen">

        {{-- LAYOUT: dos columnas en escritorio, apilado en móvil --}}
        <div class="min-h-screen flex flex-col lg:flex-row">

            {{-- ===== PANEL IZQUIERDO: Arte cultural + SVG ===== --}}
            <div class="relative lg:w-3/5 min-h-[40vh] lg:min-h-screen overflow-hidden flex flex-col justify-between" style="background: #1a1f3e;">

                {{-- SVG de fondo animado --}}
                <div class="absolute inset-0 w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1200 800">
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%"   stop-color="#3650BB" />
                                <stop offset="40%"  stop-color="#0CB29C" />
                                <stop offset="70%"  stop-color="#FF6702" />
                                <stop offset="100%" stop-color="#E92050" />
                            </linearGradient>
                        </defs>
                        <!-- Forma de montañas y curvas -->
                        <path class="svg-wave" d="M0,400 C200,200 400,500 600,350 C800,200 1000,450 1200,300 L1200,800 L0,800 Z"
                              fill="url(#grad1)" opacity="0.6"/>
                        <!-- Siluetas fluidas -->
                        <circle class="svg-float-1" cx="250" cy="200" r="80"  fill="#FFC400" opacity="0.4"/>
                        <circle class="svg-float-2" cx="900" cy="150" r="60"  fill="#E92050" opacity="0.4"/>
                        <!-- Formas culturales -->
                        <ellipse class="svg-float-3" cx="700" cy="500" rx="180" ry="50"  fill="#0CB29C" opacity="0.4"/>
                        <ellipse class="svg-float-1" cx="400" cy="600" rx="200" ry="70"  fill="#FFC400" opacity="0.35"/>
                    </svg>
                </div>

                {{-- Contenido sobre el SVG --}}
                <div class="relative z-10 flex flex-col justify-between h-full p-8 lg:p-14">
                    {{-- Logo --}}
                    <div>
                        <a href="/">
                            <img src="{{ asset('images/sec-cultura-logo.jpg') }}" alt="Secretaría de Cultura" class="h-16 w-auto rounded-md shadow-md">
                        </a>
                    </div>

                    {{-- Tagline central --}}
                    <div class="py-10 lg:py-0">
                        <h1 class="text-white text-4xl lg:text-5xl font-black leading-tight drop-shadow-lg">
                            Cultura que<br>
                            <span class="text-yellow-300">nos mueve.</span>
                        </h1>
                        <p class="mt-4 text-white/75 text-lg max-w-sm leading-relaxed">
                            Gestiona sedes, cursos e inscripciones para todas las comunidades de Manizales.
                        </p>

                        {{-- Puntos decorativos de colores de marca --}}
                        <div class="flex gap-3 mt-8">
                            <span class="w-3 h-3 rounded-full bg-mzl-yellow animate-pulse"></span>
                            <span class="w-3 h-3 rounded-full bg-mzl-teal animate-pulse delay-100"></span>
                            <span class="w-3 h-3 rounded-full bg-mzl-orange animate-pulse delay-200"></span>
                            <span class="w-3 h-3 rounded-full bg-mzl-pink animate-pulse delay-300"></span>
                        </div>
                    </div>

                    {{-- Pie del panel --}}
                    <p class="text-white/40 text-xs">
                        © {{ date('Y') }} Secretaría de Cultura de Manizales
                    </p>
                </div>
            </div>

            {{-- ===== PANEL DERECHO: Formulario ===== --}}
            <div class="lg:w-2/5 flex items-center justify-center p-8 lg:p-16 bg-white">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>
