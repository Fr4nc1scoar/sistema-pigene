@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bienestar Social</h1>
            <p class="mt-2 text-sm text-gray-700">Generación de reportes y estadísticas de personal.</p>
        </div>
        <div class="mt-4 sm:mt-0 hide-print">
            <button onclick="window.print()" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pigene-500 focus:ring-offset-2 sm:w-auto">
                <svg class="mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.198-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Filtros Unificados -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-600 mb-6 hide-print">
        <form action="{{ route('social-welfare.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Búsqueda General -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-gray-800">Buscar (Nombre/Cédula)</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500" placeholder="Ej: Pedro Perez o 12345678">
                </div>
                <!-- Tipo Trabajador -->
                <div>
                    <label class="block text-xs font-semibold text-gray-800">Tipo Trabajador</label>
                    <select name="employee_type" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500">
                        <option value="">Todos</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}" {{ request('employee_type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Cargo -->
                <div>
                    <label class="block text-xs font-semibold text-gray-800">Cargo</label>
                    <select name="position_id" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500">
                        <option value="">Todos</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-t border-gray-200 pt-4">
                <!-- Mes Cumpleaños -->
                <div>
                    <label class="block text-xs font-semibold text-gray-800">Mes Cumpleaños</label>
                    <select name="birthday_month" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500">
                        <option value="">Cualquiera</option>
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ request('birthday_month') == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Profesión -->
                <div>
                    <label class="block text-xs font-semibold text-gray-800">Profesión</label>
                    <input type="text" name="profession" value="{{ request('profession') }}" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500" placeholder="Ej: Ingeniero">
                </div>
                <!-- Género -->
                <div>
                    <label class="block text-xs font-semibold text-gray-800">Género</label>
                    <select name="gender" class="mt-1 block w-full rounded-md border-gray-400 text-sm focus:border-pigene-500 focus:ring-pigene-500">
                        <option value="">Todos</option>
                        <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <!-- Hijos -->
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="has_children" value="1" id="has_children" {{ request('has_children') ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-400 text-pigene-600 focus:ring-pigene-600">
                    <label for="has_children" class="ml-2 text-sm text-gray-900 font-semibold">¿Con Hijos?</label>
                </div>
                <!-- Con Patologías -->
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="has_pathologies" value="1" id="has_pathologies" {{ request('has_pathologies') ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-400 text-pigene-600 focus:ring-pigene-600">
                    <label for="has_pathologies" class="ml-2 text-sm text-gray-900 font-semibold">Con Datos Médicos</label>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                 <a href="{{ route('social-welfare.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-400 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Limpiar Filtros</a>
                 <button type="submit" name="export_excel" value="1" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Excel
                 </button>
                 <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-pigene-800 hover:bg-pigene-900">Filtrar Resultados</button>
            </div>
        </form>
    </div>

    <!-- Resultados -->
    <div x-data="{
        cols: {
            age: true,
            birthdate: false,
            position: true,
            profession: {{ request('profession') ? 'true' : 'false' }},
            employee_type: true,
            bank: false,
            pathologies: true,
            dependents: true
        }
    }">
        <div class="mb-4 flex justify-end hide-print space-x-4">
             <div class="relative inline-block text-left" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-400 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none" aria-haspopup="true" aria-expanded="true">
                  Columnas Visibles
                  <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
                <div x-show="open" @click.away="open = false" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                  <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.age" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Edad / Género
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.birthdate" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Fecha Nacimiento
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.position" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Cargo
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.profession" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Profesión
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.bank" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Cuentas Bancaria
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.pathologies" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Datos Médicos
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.employee_type" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Tipo Trabajador
                    </label>
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                        <input type="checkbox" x-model="cols.dependents" class="mr-2 rounded text-pigene-600 focus:ring-pigene-500"> Carga Familiar
                    </label>
                  </div>
                </div>
             </div>
        </div>

        <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Trabajador</th>
                        <th x-show="cols.age" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Edad / Género</th>
                        <th x-show="cols.birthdate" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">F. Nacimiento</th>
                        <th x-show="cols.employee_type" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tipo</th>
                        <th x-show="cols.position" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cargo</th>
                        <th x-show="cols.profession" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Profesión</th>
                        <th x-show="cols.bank" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Cuenta Bancaria</th>
                        <th x-show="cols.pathologies" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Datos Médicos</th>
                        <th x-show="cols.dependents" scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Carga Fam. Detalle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($employees as $employee)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            {{ $employee->last_name }}, {{ $employee->first_name }}
                            <div class="text-xs text-gray-500 font-normal">{{ $employee->id_card }}</div>
                            <div class="text-xs text-gray-400">{{ $employee->employee_type }}</div>
                        </td>
                        <td x-show="cols.age" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $employee->birthdate ? $employee->birthdate->age . ' años' : 'N/A' }}
                            <span class="ml-1 inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-800">{{ $employee->gender }}</span>
                        </td>
                        <td x-show="cols.birthdate" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $employee->birthdate ? $employee->birthdate->format('d/m/Y') : '-' }}
                        </td>
                        </td>
                        <td x-show="cols.employee_type" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $employee->employee_type }}
                        </td>
                        <td x-show="cols.position" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $employee->position->name }}
                        </td>
                        <td x-show="cols.profession" class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $employee->profession ?? '-' }}
                            <div class="text-xs text-gray-400">{{ $employee->education_level }}</div>
                        </td>
                        <td x-show="cols.bank" class="px-3 py-4 text-sm text-gray-500">
                            @foreach($employee->bankAccounts as $acc)
                                <div class="text-xs whitespace-nowrap" title="{{ $acc->bank_name }}">
                                    <span class="font-semibold">{{ Str::limit($acc->bank_name, 6) }}:</span> {{ $acc->account_number }}
                                </div>
                            @endforeach
                            @if($employee->bankAccounts->isEmpty()) - @endif
                        </td>
                        <td x-show="cols.pathologies" class="px-3 py-4 text-sm text-gray-500 break-words max-w-xs">
                            @if($employee->medical_observations)
                                <div class="text-xs italic mb-1">{{ Str::limit($employee->medical_observations, 50) }}</div>
                            @endif
                            @forelse($employee->pathologies as $patho)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700">{{ $patho->name }}</span>
                            @empty
                                <span class="text-xs text-gray-400">-</span>
                            @endforelse
                        </td>
                         <td x-show="cols.dependents" class="px-3 py-4 text-sm text-gray-500">
                            @if($employee->dependents->count() > 0)
                                <ul class="list-disc pl-4 text-xs">
                                @foreach($employee->dependents as $dep)
                                    <li>
                                        {{ Str::limit($dep->name, 15) }} ({{ $dep->birthdate->age }}a)
                                        <br><span class="text-xs text-gray-400">CI: {{ $dep->id_card ?? 'N/A' }} | {{ $dep->condition }}</span>
                                    </li>
                                @endforeach
                                </ul>
                            @else
                                <span class="text-xs text-gray-400">Sin carga</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                     <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No hay resultados para estos filtros.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .hide-print { display: none !important; }
        body { background: white; }
        .shadow, .ring-1 { box-shadow: none !important; }
    }
</style>
@endsection
