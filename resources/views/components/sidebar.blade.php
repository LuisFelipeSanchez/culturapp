{{--
    Sidebar component - CulturApp
    Usage: <x-sidebar />
    Estado colapsado persiste en localStorage via Alpine.js
--}}
<div
    x-data="{
        collapsed: localStorage.getItem('sidebar_collapsed') === 'true',
        toggle() {
            this.collapsed = !this.collapsed;
            localStorage.setItem('sidebar_collapsed', this.collapsed);
        }
    }"
    :class="collapsed ? 'w-[72px]' : 'w-64'"
    class="relative hidden md:flex flex-col h-screen z-40 transition-all duration-300 ease-in-out overflow-hidden shrink-0 select-none"
    style="background: linear-gradient(175deg, #1a1f3e 0%, #3650BB 60%, #0e2a50 100%);"
>
    {{-- Blobs decorativos --}}
    <div class="pointer-events-none absolute w-48 h-48 rounded-full bottom-24 right-[-60px] opacity-[0.10]"
         style="background: radial-gradient(circle, #FFC400, transparent 70%)"></div>
    <div class="pointer-events-none absolute w-32 h-32 rounded-full top-48 left-[-30px] opacity-[0.12]"
         style="background: radial-gradient(circle, #E92050, transparent 70%)"></div>
    <div class="pointer-events-none absolute w-28 h-28 rounded-full bottom-16 left-4 opacity-[0.10]"
         style="background: radial-gradient(circle, #0CB29C, transparent 70%)"></div>

    {{-- ===== Cabecera: logo + botón colapso ===== --}}
    <div class="relative z-10 flex items-center h-[68px] border-b border-white/10 shrink-0 overflow-hidden"
         :class="collapsed ? 'justify-center px-0' : 'justify-between px-3'">

        {{-- Logo (oculto cuando colapsado) --}}
        <a x-show="!collapsed"
           x-transition:enter="transition-opacity duration-150 delay-100"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100"
           x-transition:leave="transition-opacity duration-75"
           x-transition:leave-start="opacity-100"
           x-transition:leave-end="opacity-0"
           href="{{ route('dashboard') }}" class="shrink-0">
            <img src="{{ asset('images/sec-cultura-logo.jpg') }}"
                 alt="CulturApp"
                 class="h-10 w-auto rounded-md shadow-md object-contain">
        </a>

        {{-- Botón toggle — siempre visible y centrado cuando colapsado --}}
        <button
            @click="toggle()"
            :title="collapsed ? 'Expandir menú' : 'Colapsar menú'"
            class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl
                   text-white/60 hover:text-white hover:bg-white/10 transition-all duration-200"
        >
            <svg x-show="collapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <svg x-show="!collapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
    </div>

    {{-- Barra de 5 colores de marca --}}
    <div class="relative z-10 flex h-[3px] shrink-0">
        <div class="flex-1 bg-mzl-blue"></div>
        <div class="flex-1 bg-mzl-teal"></div>
        <div class="flex-1 bg-mzl-orange"></div>
        <div class="flex-1 bg-mzl-pink"></div>
        <div class="flex-1 bg-mzl-yellow"></div>
    </div>

    {{-- ===== Navegación ===== --}}
    <nav class="relative z-10 flex-1 flex flex-col px-2 py-5 gap-0.5">

        {{-- Label sección Principal --}}
        <p x-show="!collapsed"
           x-transition:enter="transition-opacity duration-200 delay-150"
           x-transition:enter-start="opacity-0"
           x-transition:enter-end="opacity-100"
           x-transition:leave="transition-opacity duration-100"
           x-transition:leave-start="opacity-100"
           x-transition:leave-end="opacity-0"
           class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 pb-1 pt-0">
            Principal
        </p>

        @php
            $items = [
                [
                    'route'  => 'dashboard',
                    'label'  => 'Dashboard',
                    'match'  => 'dashboard',
                    'color'  => 'mzl-teal',
                    'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                ],
                [
                    'route'  => 'my-courses.index',
                    'label'  => 'Mis Cursos',
                    'match'  => 'my-courses.*',
                    'color'  => 'mzl-yellow',
                    'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                ],
                [
                    'route'  => 'sedes.index',
                    'label'  => 'Sedes públicas',
                    'match'  => 'sedes.index',
                    'color'  => 'mzl-blue',
                    'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                ],
                [
                    'route'  => 'noticias.index',
                    'label'  => 'Noticias públicas',
                    'match'  => 'noticias.index',
                    'color'  => 'mzl-pink',
                    'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
                ],
            ];

            // Solo admin/superadmin ven gestión de sedes en la sección principal
            if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin()) {
                $items[] = [
                    'route'  => 'admin.manage',
                    'label'  => 'Gestionar Sedes',
                    'match'  => 'admin.manage',
                    'color'  => 'mzl-orange',
                    'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                ];
            }
        @endphp

        @foreach($items as $item)
        @php $active = request()->routeIs($item['match']); @endphp
        <a href="{{ route($item['route']) }}"
           :title="collapsed ? '{{ $item['label'] }}' : ''"
           class="group relative flex items-center gap-3 px-[10px] py-[10px] rounded-xl transition-all duration-200
               {{ $active ? 'bg-white/12 text-white' : 'text-white/65 hover:bg-white/8 hover:text-white' }}">

            {{-- Indicador lateral activo --}}
            @if($active)
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full bg-mzl-yellow"></span>
            @endif

            {{-- Icono --}}
            <span class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-200
                {{ $active ? 'bg-' . $item['color'] . '/25' : 'bg-white/5 group-hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $item['icon'] !!}
                </svg>
            </span>

            {{-- Texto --}}
            <span x-show="!collapsed"
                  x-transition:enter="transition-opacity duration-150 delay-100"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"
                  x-transition:leave="transition-opacity duration-75"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  class="font-semibold text-sm whitespace-nowrap">
                {{ $item['label'] }}
            </span>

            {{-- Dot activo --}}
            @if($active)
            <span x-show="!collapsed" class="ml-auto w-2 h-2 rounded-full bg-mzl-yellow animate-pulse shrink-0"
                  x-transition:enter="transition-opacity duration-150 delay-150"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100"></span>
            @endif
        </a>
        @endforeach

        {{-- SECCIÓN DE GESTIÓN: Solo para Admin y SuperAdmin --}}
        @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
            {{-- Separador Gestión --}}
            <p x-show="!collapsed"
            x-transition:enter="transition-opacity duration-200 delay-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-75"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="text-white/30 text-[10px] font-bold uppercase tracking-widest px-3 pt-5 pb-1">
                Gestión
            </p>
            <div x-show="collapsed" class="border-t border-white/10 my-3 mx-2"></div>


            {{-- Cursos: ahora activo --}}
            @php $courseActive = request()->routeIs('admin.cursos.*'); @endphp
            <a href="{{ route('admin.cursos.index') }}"
            :title="collapsed ? 'Cursos' : ''"
            class="group relative flex items-center gap-3 px-[10px] py-[10px] rounded-xl transition-all duration-200
                {{ $courseActive ? 'bg-white/12 text-white' : 'text-white/65 hover:bg-white/8 hover:text-white' }}">
                @if($courseActive)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full bg-mzl-yellow"></span>
                @endif
                <span class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-200
                    {{ $courseActive ? 'bg-mzl-teal/25' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </span>
                <span x-show="!collapsed"
                    x-transition:enter="transition-opacity duration-150 delay-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-75"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="font-semibold text-sm whitespace-nowrap">Cursos</span>
                @if($courseActive)
                <span x-show="!collapsed" class="ml-auto w-2 h-2 rounded-full bg-mzl-yellow animate-pulse shrink-0"></span>
                @endif
            </a>

            {{-- Noticias --}}
            @php $newsActive = request()->routeIs('admin.noticias.*'); @endphp
            <a href="{{ route('admin.noticias.index') }}"
            :title="collapsed ? 'Noticias' : ''"
            class="group relative flex items-center gap-3 px-[10px] py-[10px] rounded-xl transition-all duration-200
                {{ $newsActive ? 'bg-white/12 text-white' : 'text-white/65 hover:bg-white/8 hover:text-white' }}">
                @if($newsActive)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full bg-mzl-yellow"></span>
                @endif
                <span class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-200
                    {{ $newsActive ? 'bg-mzl-blue/25' : 'bg-white/5 group-hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </span>
                <span x-show="!collapsed"
                    x-transition:enter="transition-opacity duration-150 delay-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-75"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="font-semibold text-sm whitespace-nowrap">Noticias</span>
                @if($newsActive)
                <span x-show="!collapsed" class="ml-auto w-2 h-2 rounded-full bg-mzl-yellow animate-pulse shrink-0"></span>
                @endif
            </a>


            {{-- Gestión de Usuarios: Solo SuperAdmin --}}
            @if(Auth::user()->isSuperAdmin())
                @php $usersActive = request()->routeIs('admin.users.*'); @endphp
                <a href="{{ route('admin.users.index') }}"
                :title="collapsed ? 'Gestión de Usuarios' : ''"
                class="group relative flex items-center gap-3 px-[10px] py-[10px] rounded-xl transition-all duration-200
                    {{ $usersActive ? 'bg-white/12 text-white' : 'text-white/65 hover:bg-white/8 hover:text-white' }}">
                    @if($usersActive)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 rounded-r-full bg-mzl-yellow"></span>
                    @endif
                    <span class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl transition-all duration-200
                        {{ $usersActive ? 'bg-mzl-pink/25' : 'bg-white/5 group-hover:bg-white/10' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </span>
                    <span x-show="!collapsed"
                        x-transition:enter="transition-opacity duration-150 delay-100"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-75"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="font-semibold text-sm whitespace-nowrap">Gestión de Usuarios</span>
                    @if($usersActive)
                    <span x-show="!collapsed" class="ml-auto w-2 h-2 rounded-full bg-mzl-yellow animate-pulse shrink-0"></span>
                    @endif
                </a>
            @endif
        @endif

    </nav>

    {{-- ===== Perfil + Logout ===== --}}
    <div class="relative z-10 border-t border-white/10 p-2 shrink-0 space-y-1">
        <a href="{{ route('profile.edit') }}"
           :title="collapsed ? '{{ Auth::user()->name }}' : ''"
           class="flex items-center gap-3 px-[10px] py-[10px] rounded-xl text-white/65 hover:bg-white/10 hover:text-white transition-all duration-200">
            <img src="{{ Auth::user()->avatarUrl() }}"
                 alt="{{ Auth::user()->name }}"
                 class="w-9 h-9 rounded-full object-cover shrink-0 border-2 border-white/20">
            <div x-show="!collapsed"
                 x-transition:enter="transition-opacity duration-150 delay-100"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity duration-75"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex-1 min-w-0">
                <p class="text-white text-xs font-bold truncate">{{ Auth::user()->name }}</p>
                <p class="text-white/40 text-[10px] truncate">{{ Auth::user()->email }}</p>
            </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    :title="collapsed ? 'Cerrar sesión' : ''"
                    class="w-full flex items-center gap-3 px-[10px] py-[10px] rounded-xl text-white/50 hover:bg-mzl-pink/20 hover:text-mzl-pink transition-all duration-200 text-sm font-semibold">
                <span class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl bg-white/5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                <span x-show="!collapsed"
                      x-transition:enter="transition-opacity duration-150 delay-100"
                      x-transition:enter-start="opacity-0"
                      x-transition:enter-end="opacity-100"
                      x-transition:leave="transition-opacity duration-75"
                      x-transition:leave-start="opacity-100"
                      x-transition:leave-end="opacity-0"
                      class="whitespace-nowrap">
                    Cerrar sesión
                </span>
            </button>
        </form>
    </div>
</div>
