@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Trabajadores</h1>
            <p class="mt-2 text-sm text-gray-700">Listado activo de personal del Consejo Legislativo.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('employees.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-pigene-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pigene-700 focus:outline-none focus:ring-2 focus:ring-pigene-500 focus:ring-offset-2 sm:w-auto">
                Registrar Nuevo
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Search -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('employees.index') }}" method="GET" class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="block w-full rounded-md border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-clebne-600 sm:text-sm sm:leading-6" placeholder="Buscar por cédula, cargo o tipo...">
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Empleado</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cargo / Adscripción</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipo</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ingreso</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Acciones</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($employees as $employee)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full bg-gray-100 object-cover" src="https://ui-avatars.com/api/?name={{ $employee->first_name }}+{{ $employee->last_name }}&background=0ea5e9&color=fff" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="font-medium text-gray-900">{{ $employee->last_name }}, {{ $employee->first_name }}</div>
                                <div class="text-gray-500 text-xs">C.I. {{ $employee->id_card }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <div class="text-gray-900 font-medium">{{ $employee->position->name ?? 'Sin Cargo' }}</div>
                        <div class="text-gray-500 text-xs">{{ $employee->position->direction->name ?? 'Sin Adscripción' }}</div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            {{ $employee->employee_type }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        {{ $employee->institution_entry_date ? $employee->institution_entry_date->format('d/m/Y') : '-' }}
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        <a href="{{ route('employees.edit', $employee) }}" class="text-pigene-600 hover:text-pigene-900 mr-4">Editar</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-gray-500">
                        No se encontraron trabajadores registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection
