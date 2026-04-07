@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="min-h-screen bg-gray-50">

    {{-- Header --}}
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 justify-between">
                <div>
                    <h1 class="text-2xl font-black text-gray-900">Gestión de Usuarios</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Panel exclusivo de superadministrador · {{ $users->total() }} usuarios registrados</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-mzl-pink bg-mzl-pink/10 px-3 py-2 rounded-xl border border-mzl-pink/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Acceso SuperAdmin
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8">

        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                {{-- Búsqueda libre --}}
                <div class="lg:col-span-1 relative">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Buscar</label>
                    <div class="relative">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nombre, email o documento..."
                               class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50">
                    </div>
                </div>

                {{-- Tipo de documento --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de documento</label>
                    <select name="document_type" class="w-full text-sm rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 py-2.5">
                        <option value="">Todos</option>
                        <option value="cc"        {{ request('document_type') === 'cc'        ? 'selected' : '' }}>Cédula (CC)</option>
                        <option value="ti"        {{ request('document_type') === 'ti'        ? 'selected' : '' }}>Tarjeta de Identidad (TI)</option>
                        <option value="ce"        {{ request('document_type') === 'ce'        ? 'selected' : '' }}>Cédula de Extranjería (CE)</option>
                        <option value="pasaporte" {{ request('document_type') === 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                    </select>
                </div>

                {{-- Rol --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Rol</label>
                    <select name="role" class="w-full text-sm rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 py-2.5">
                        <option value="">Todos los roles</option>
                        <option value="citizen"    {{ request('role') === 'citizen'    ? 'selected' : '' }}>Ciudadano</option>
                        <option value="admin"      {{ request('role') === 'admin'      ? 'selected' : '' }}>Administrador</option>
                        <option value="super_admin"{{ request('role') === 'super_admin'? 'selected' : '' }}>SuperAdmin</option>
                    </select>
                </div>

                {{-- Estado / Sanción --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Estado</label>
                    <select name="flagged" class="w-full text-sm rounded-xl border-gray-200 focus:ring-mzl-blue focus:border-mzl-blue bg-gray-50 py-2.5">
                        <option value="">Todos</option>
                        <option value="0" {{ request('flagged') === '0' ? 'selected' : '' }}>Sin sanción</option>
                        <option value="1" {{ request('flagged') === '1' ? 'selected' : '' }}>Sancionados</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-gray-600 font-semibold flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Limpiar filtros
                </a>
                <button type="submit" class="bg-mzl-blue text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-opacity-90 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                    Aplicar filtros
                </button>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            @if($users->isEmpty())
                <div class="p-16 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="font-bold text-gray-400">No se encontraron usuarios con esos criterios.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Usuario</th>
                                <th class="px-6 py-4 text-center">Documento</th>
                                <th class="px-6 py-4 text-center">Rol</th>
                                <th class="px-6 py-4 text-center">Cursos</th>
                                <th class="px-6 py-4 text-center">Promedio</th>
                                <th class="px-6 py-4 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($users as $user)
                            @php
                                $avg = isset($userAverages[$user->id]) ? round($userAverages[$user->id], 1) : null;
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition group">

                                {{-- Usuario --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative shrink-0">
                                            <img src="{{ $user->avatarUrl() }}" class="w-10 h-10 rounded-full border-2 border-gray-100 object-cover {{ $user->is_flagged ? 'grayscale' : '' }}">
                                            @if($user->is_flagged)
                                            <div class="absolute -top-1 -right-1 bg-mzl-pink rounded-full p-0.5 border border-white">
                                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 leading-tight">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Documento --}}
                                <td class="px-6 py-4 text-center">
                                    @if($user->document_number)
                                        <span class="inline-block bg-gray-100 text-gray-700 font-bold text-xs px-2.5 py-1.5 rounded-lg">
                                            {{ strtoupper($user->document_type) }} {{ $user->document_number }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>

                                {{-- Rol --}}
                                <td class="px-6 py-4 text-center">
                                    @if($user->role === 'super_admin')
                                        <span class="text-[10px] font-black uppercase bg-mzl-pink/10 text-mzl-pink px-2.5 py-1 rounded-full">SuperAdmin</span>
                                    @elseif($user->role === 'admin')
                                        <span class="text-[10px] font-black uppercase bg-mzl-blue/10 text-mzl-blue px-2.5 py-1 rounded-full">Admin</span>
                                    @else
                                        <span class="text-[10px] font-black uppercase bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">Ciudadano</span>
                                    @endif
                                </td>

                                {{-- Cursos inscritos --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-gray-700">{{ $user->enrollments_count }}</span>
                                </td>

                                {{-- Promedio general --}}
                                <td class="px-6 py-4 text-center">
                                    @if($avg !== null)
                                        <span class="font-black text-base {{ $avg >= 3.0 ? 'text-green-600' : 'text-mzl-pink' }}">{{ number_format($avg, 1) }}</span>
                                        <span class="text-xs text-gray-400">/5.0</span>
                                    @else
                                        <span class="text-gray-300 text-xs">Sin notas</span>
                                    @endif
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 text-center">
                                    @if($user->is_flagged)
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[10px] font-black uppercase bg-mzl-pink/10 text-mzl-pink px-2.5 py-1 rounded-full">Sancionado</span>
                                            @if($user->flagged_reason)
                                            <span class="text-[10px] text-gray-400 italic max-w-[140px] truncate" title="{{ $user->flagged_reason }}">
                                                "{{ $user->flagged_reason }}"
                                            </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] font-black uppercase bg-green-50 text-green-600 px-2.5 py-1 rounded-full">Activo</span>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginación --}}
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->links() }}
                </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
