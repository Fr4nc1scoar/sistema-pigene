@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-3xl font-bold leading-6 text-gray-900">Dashboard General</h1>
            <p class="mt-2 text-sm text-gray-700">Bienvenido al sistema de gestión PIGENE del Consejo Legislativo.</p>
        </div>
    </div>
    
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Módulo Personal -->
        <a href="{{ route('employees.index') }}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:ring-pigene-500 hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-pigene-50 group-hover:bg-pigene-100 transition-colors">
                    <svg class="h-6 w-6 text-pigene-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold leading-7 text-gray-900">Personal / Fichas</h3>
                <p class="mt-1 text-sm leading-6 text-gray-500">Gestión de trabajadores, datos personales y organizativos.</p>
            </div>
        </a>

        <!-- Módulo Bienestar Social -->
        <a href="{{ route('social-welfare.index') }}" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:ring-pigene-500 hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-pink-50 group-hover:bg-pink-100 transition-colors">
                    <svg class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                       <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold leading-7 text-gray-900">Bienestar Social</h3>
                <p class="mt-1 text-sm leading-6 text-gray-500">Reportes de salud, cargas familiares y beneficios.</p>
            </div>
        </a>

        <!-- Módulo Nómina -->
        <a href="#" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:ring-pigene-500 hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 group-hover:bg-green-100 transition-colors">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold leading-7 text-gray-900">Nómina</h3>
                <p class="mt-1 text-sm leading-6 text-gray-500">Cálculos salariales, tabuladores y asignaciones.</p>
            </div>
        </a>

        <!-- Módulo Registro y Control -->
        <a href="#" class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 hover:ring-pigene-500 hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-50 group-hover:bg-orange-100 transition-colors">
                    <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-base font-semibold leading-7 text-gray-900">Registro y Control</h3>
                <p class="mt-1 text-sm leading-6 text-gray-500">Auditoría, configuraciones y mantenimiento.</p>
            </div>
        </a>
    </div>

    <!-- Stats Rapidos -->
    <div class="mt-12">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Resumen Rápido</h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                <dt class="truncate text-sm font-medium text-gray-500">Total Trabajadores Activos</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ \App\Models\Employee::count() }}</dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                 <dt class="truncate text-sm font-medium text-gray-500">Nómina Estimada Mensual</dt>
                 <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">Bs. --</dd>
            </div>
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                 <dt class="truncate text-sm font-medium text-gray-500">Auditoría (Eventos Hoy)</dt>
                 <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ \App\Models\AuditLog::whereDate('created_at', now())->count() }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
