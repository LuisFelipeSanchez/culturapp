<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedes — CulturApp Manizales</title>
    <meta name="description" content="Mapa interactivo de las Casas de la Cultura de Manizales. Encuentra cursos, noticias y más.">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Nunito', sans-serif; }

        #map {
            height: 100%;
            width: 100%;
            z-index: 0;
        }

        /* Marcador personalizado */
        .marker-pin {
            width: 36px;
            height: 36px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.3);
        }
        .marker-inner {
            transform: rotate(45deg);
            font-size: 16px;
            line-height: 1;
        }

        /* Popup customizado */
        .leaflet-popup-content-wrapper {
            border-radius: 16px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15) !important;
            border: none !important;
            padding: 0 !important;
            overflow: hidden;
        }
        .leaflet-popup-content {
            margin: 0 !important;
            width: 260px !important;
        }
        .leaflet-popup-tip-container {
            margin-top: -1px;
        }
        .leaflet-popup-close-button {
            top: 8px !important;
            right: 8px !important;
            color: white !important;
            font-size: 18px !important;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- NAV --}}
<nav class="bg-mzl-blue px-4 sm:px-8 py-3 flex items-center justify-between shrink-0 shadow-md sticky top-0 z-[1001]">
    <a href="/" class="flex items-center gap-3">
        <img src="{{ asset('images/sec-cultura-logo.jpg') }}" alt="CulturApp" class="h-10 w-auto rounded-md">
    </a>
    <div class="flex items-center gap-4">
        <div class="hidden sm:flex gap-1.5 mr-4">
            <span class="w-2.5 h-2.5 rounded-full bg-white/40"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-teal"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-orange"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-pink"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-mzl-yellow"></span>
        </div>
        <a href="{{ route('noticias.index') }}" class="text-sm font-bold text-white/80 hover:text-white transition hidden sm:block mr-3">Noticias</a>
        @auth
        <a href="{{ route('dashboard') }}" class="text-sm font-bold text-white/80 hover:text-white transition">Panel</a>
        @else
        <a href="{{ route('login') }}" class="text-sm font-bold bg-white text-mzl-blue px-4 py-2 rounded-xl hover:bg-gray-100 transition shadow-sm">Ingresar</a>
        @endauth
    </div>
</nav>

{{-- LAYOUT: mapa izquierda + panel lista derecha --}}
<div class="flex flex-col md:flex-row flex-1 overflow-hidden" style="height: calc(100vh - 65px)">

    {{-- MAPA --}}
    <div class="flex-1 relative">
        <div id="map" class="absolute inset-0"></div>

        <div class="md:hidden absolute top-4 left-4 right-4 z-[999]">
            <div class="bg-white/95 backdrop-blur rounded-2xl shadow-lg border border-gray-100 overflow-hidden relative">
                <select id="mobile-sede-selector" class="w-full border-0 focus:ring-0 text-gray-800 font-bold py-3.5 px-4 bg-transparent outline-none cursor-pointer">
                    <option value="" disabled selected>Selecciona una sede...</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" data-lat="{{ $sede->latitude }}" data-lng="{{ $sede->longitude }}">
                            {{ $sede->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Leyenda flotante --}}
        <div class="absolute bottom-5 left-5 z-[999] bg-white/90 backdrop-blur rounded-2xl shadow-lg px-4 py-3 text-xs space-y-1.5">
            <p class="font-bold text-gray-700 mb-2 text-[11px] uppercase tracking-wide">Leyenda</p>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-mzl-blue inline-block"></span>
                <span class="text-gray-600">Zona urbana</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-mzl-teal inline-block"></span>
                <span class="text-gray-600">Zona rural</span>
            </div>
        </div>
    </div>

    {{-- PANEL LATERAL: lista de sedes --}}
    <div class="hidden md:flex w-80 shrink-0 bg-white border-l border-gray-200 flex-col" style="height:100%;">
        <div class="px-5 py-4 border-b border-gray-100 shrink-0">
            <h1 class="font-black text-lg text-gray-900">Casas de la Cultura</h1>
            <p class="text-gray-400 text-xs mt-0.5">Manizales — {{ $sedes->count() }} sedes</p>
        </div>

        <div class="overflow-y-auto flex-1 divide-y divide-gray-50">
            @forelse($sedes as $sede)
            <a href="{{ route('sedes.show', $sede) }}"
               class="sede-card flex items-start gap-3 px-5 py-4 hover:bg-gray-50 transition cursor-pointer group"
               data-id="{{ $sede->id }}"
               data-lat="{{ $sede->latitude }}"
               data-lng="{{ $sede->longitude }}">
                {{-- Color indicador zona --}}
                <span class="w-2.5 h-2.5 rounded-full mt-1.5 shrink-0 {{ $sede->zone === 'urbana' ? 'bg-mzl-blue' : 'bg-mzl-teal' }}"></span>
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 text-sm group-hover:text-mzl-blue transition truncate">{{ $sede->name }}</p>
                    <p class="text-gray-400 text-xs truncate mt-0.5">{{ $sede->address }}</p>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                            {{ $sede->zone === 'urbana' ? 'bg-mzl-blue/10 text-mzl-blue' : 'bg-mzl-teal/10 text-mzl-teal' }}">
                            {{ ucfirst($sede->zone) }}
                        </span>
                        @if($sede->courses_count ?? $sede->courses->count())
                        <span class="text-xs text-gray-400">{{ $sede->courses->count() }} cursos</span>
                        @endif
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-mzl-blue transition shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @empty
            <div class="px-5 py-10 text-center text-gray-400">
                <p class="text-3xl mb-2">🏛</p>
                <p class="text-sm">No hay sedes registradas.</p>
            </div>
            @endforelse
        </div>

        {{-- Barra de color en la parte inferior --}}
        <div class="flex h-1.5 shrink-0">
            <div class="flex-1 bg-mzl-blue"></div>
            <div class="flex-1 bg-mzl-teal"></div>
            <div class="flex-1 bg-mzl-orange"></div>
            <div class="flex-1 bg-mzl-pink"></div>
            <div class="flex-1 bg-mzl-yellow"></div>
        </div>
    </div>
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ─── Datos de sedes desde Laravel ───────────────────────────────────────
@php
    $sedesData = $sedes->map(function ($s) {
        return [
            'id'          => $s->id,
            'name'        => $s->name,
            'address'     => $s->address,
            'zone'        => $s->zone,
            'description' => $s->description,
            'lat'         => (float) $s->latitude,
            'lng'         => (float) $s->longitude,
            'courses'     => $s->courses->count(),
            'news'        => $s->news->count(),
            'url'         => route('sedes.show', $s),
            'contact'     => $s->contact_info,
        ];
    })->values()->toArray();
@endphp
    const sedes = {!! json_encode($sedesData) !!};

    // ─── Inicializar mapa centrado en Manizales ──────────────────────────────
    const map = L.map('map', {
        center: [5.0703, -75.5138],
        zoom: 13,
        zoomControl: true,
    });

    // Tiles OpenStreetMap — sin API key, completamente gratuito
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(map);

    // ─── Función: crear icono marcador ───────────────────────────────────────
    function createIcon(zone) {
        const color = zone === 'urbana' ? '#3650BB' : '#0CB29C';
        const html = `
            <div style="
                width:36px;height:36px;
                background:${color};
                border-radius:50% 50% 50% 0;
                transform:rotate(-45deg);
                display:flex;align-items:center;justify-content:center;
                box-shadow:0 4px 14px rgba(0,0,0,0.3);
                border:2px solid rgba(255,255,255,0.6);
            ">
                <span style="transform:rotate(45deg);font-size:15px;line-height:1;">🏛</span>
            </div>`;
        return L.divIcon({
            html,
            className: '',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -38],
        });
    }

    // ─── Función: construir HTML del popup ───────────────────────────────────
    function buildPopup(s) {
        const zoneColor    = s.zone === 'urbana' ? '#3650BB' : '#0CB29C';
        const zoneBg       = s.zone === 'urbana' ? '#EEF1FB' : '#E6F7F5';
        const zoneLabel    = s.zone === 'urbana' ? 'Urbana' : 'Rural';
        const desc         = s.description
            ? s.description.substring(0, 100) + (s.description.length > 100 ? '…' : '')
            : 'Casa de la Cultura de Manizales.';

        return `
        <div style="font-family:'Nunito',sans-serif;">
            <div style="background:linear-gradient(135deg,#1a1f3e,${zoneColor});padding:14px 16px;">
                <p style="color:rgba(255,255,255,0.65);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;margin:0 0 2px">Casa de la Cultura</p>
                <p style="color:#fff;font-size:15px;font-weight:900;margin:0;line-height:1.3;">${s.name}</p>
            </div>
            <div style="padding:12px 16px;">
                <p style="color:#6b7280;font-size:11px;margin:0 0 8px;display:flex;align-items:flex-start;gap:4px;">
                    <span style="margin-top:1px;">📍</span>${s.address}
                </p>
                <p style="color:#374151;font-size:11px;line-height:1.5;margin:0 0 10px;">${desc}</p>
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:12px;flex-wrap:wrap;">
                    <span style="background:${zoneBg};color:${zoneColor};font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;">${zoneLabel}</span>
                    ${s.courses ? `<span style="background:#f3f4f6;color:#6b7280;font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;">📚 ${s.courses} cursos</span>` : ''}
                    ${s.news    ? `<span style="background:#f3f4f6;color:#6b7280;font-size:10px;font-weight:600;padding:2px 8px;border-radius:999px;">📰 ${s.news} noticias</span>` : ''}
                </div>
                <a href="${s.url}" style="
                    display:block;text-align:center;
                    background:${zoneColor};color:#fff;
                    font-size:12px;font-weight:800;
                    padding:9px 0;border-radius:10px;
                    text-decoration:none;
                    transition:opacity .2s;
                " onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    Ver noticias y cursos →
                </a>
            </div>
        </div>`;
    }

    // ─── Mapa de markers para interacción con la lista ──────────────────────
    const markers = {};

    sedes.forEach(s => {
        if (!s.lat || !s.lng) return;

        const marker = L.marker([s.lat, s.lng], { icon: createIcon(s.zone) })
            .addTo(map)
            .bindPopup(buildPopup(s), { maxWidth: 260, minWidth: 260 });

        marker.on('mouseover', () => marker.openPopup());

        markers[s.id] = marker;
    });

    // ─── Click en la lista lateral → volar al marcador ──────────────────────
    document.querySelectorAll('.sede-card').forEach(card => {
        card.addEventListener('click', e => {
            e.preventDefault();
            const id  = parseInt(card.dataset.id);
            const lat = parseFloat(card.dataset.lat);
            const lng = parseFloat(card.dataset.lng);
            if (lat && lng) {
                map.flyTo([lat, lng], 16, { animate: true, duration: 0.8 });
                if (markers[id]) setTimeout(() => markers[id].openPopup(), 900);
            }
        });
    });

    // ─── Selector móvil → volar al marcador ─────────────────────────────────
    const mobileSelector = document.getElementById('mobile-sede-selector');
    if (mobileSelector) {
        mobileSelector.addEventListener('change', e => {
            const option = e.target.options[e.target.selectedIndex];
            const id  = parseInt(option.value);
            const lat = parseFloat(option.dataset.lat);
            const lng = parseFloat(option.dataset.lng);
            if (lat && lng) {
                map.flyTo([lat, lng], 16, { animate: true, duration: 0.8 });
                if (markers[id]) setTimeout(() => markers[id].openPopup(), 900);
            }
        });
    }

    // Si alguna sede no tiene coords se ajusta el mapa a las que sí tienen
    const validCoords = sedes.filter(s => s.lat && s.lng).map(s => [s.lat, s.lng]);
    if (validCoords.length > 1) {
        map.fitBounds(validCoords, { padding: [40, 40] });
    }
</script>
</body>
</html>
