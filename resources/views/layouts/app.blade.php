<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CulturApp Manizales</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        {{-- ===== SIDEBAR (componente) ===== --}}
        <x-sidebar />

        {{-- ===== ÁREA PRINCIPAL ===== --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            <header x-data="{ mobileMenuOpen: false }" class="bg-white border-b border-gray-200 flex flex-col sticky top-0 z-30 shrink-0 shadow-sm">
                <div class="px-5 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        {{-- Hamburger --}}
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-400 hover:text-mzl-blue mr-2 focus:outline-none transition-transform" :class="mobileMenuOpen ? 'rotate-90' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <svg class="hidden sm:block w-4 h-4 text-mzl-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="hidden sm:inline text-gray-400">CulturApp</span>
                        <span class="hidden sm:inline text-gray-300">/</span>
                        <span class="text-gray-800 font-semibold capitalize">{{ ucfirst(request()->segment(1) ?: 'Inicio') }}</span>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Puntos de color de marca --}}
                        <div class="hidden sm:flex gap-1.5 items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-mzl-blue"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-mzl-teal"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-mzl-orange"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-mzl-pink"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-mzl-yellow"></span>
                        </div>
                        {{-- Avatar del usuario --}}
                        <a href="{{ route('profile.edit') }}"
                           class="w-9 h-9 rounded-full shadow hover:opacity-90 transition overflow-hidden block border border-gray-100">
                            <img src="{{ Auth::user()->avatarUrl() }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-full h-full object-cover">
                        </a>
                    </div>
                </div>

                {{-- Mobile Dropdown Menu --}}
                <div x-cloak x-show="mobileMenuOpen" class="md:hidden border-t border-gray-100 bg-gray-50"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2">
                     <div class="px-4 py-3 space-y-1.5 shadow-inner">
                         <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('dashboard') ? 'bg-mzl-blue/10 text-mzl-blue' : 'text-gray-600 hover:bg-gray-100' }}">Dashboard</a>
                         <a href="{{ route('my-courses.index') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('my-courses.*') ? 'bg-mzl-yellow/10 text-mzl-yellow' : 'text-gray-600 hover:bg-gray-100' }}">Mis Cursos</a>
                         
                         @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <a href="{{ route('admin.manage') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('admin.manage') ? 'bg-mzl-blue/10 text-mzl-blue' : 'text-gray-600 hover:bg-gray-100' }}">Gestionar Sedes</a>
                         @endif

                         <a href="{{ route('sedes.index') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('sedes.*') ? 'bg-mzl-blue/10 text-mzl-blue' : 'text-gray-600 hover:bg-gray-100' }}">Sedes (Público)</a>
                         <a href="{{ route('noticias.index') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('noticias.index') ? 'bg-mzl-pink/10 text-mzl-pink' : 'text-gray-600 hover:bg-gray-100' }}">Noticias (Público)</a>
                         
                         @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <a href="{{ route('admin.cursos.index') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('admin.cursos.*') ? 'bg-mzl-teal/10 text-mzl-teal' : 'text-gray-600 hover:bg-gray-100' }}">Cursos (Admin)</a>
                            <a href="{{ route('admin.noticias.index') }}" class="block px-4 py-2.5 rounded-xl font-bold {{ request()->routeIs('admin.noticias.*') ? 'bg-mzl-pink/10 text-mzl-pink' : 'text-gray-600 hover:bg-gray-100' }}">Noticias (Admin)</a>
                         @endif
                         
                         <div class="my-2 border-t border-gray-200"></div>
                         <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl font-bold text-gray-500 hover:text-mzl-pink hover:bg-mzl-pink/10 transition">Cerrar sesión</button>
                         </form>
                     </div>
                </div>
            </header>

            {{-- Contenido con scroll --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
            @stack('scripts')

        </div>
    </div>

</body>
</html>
