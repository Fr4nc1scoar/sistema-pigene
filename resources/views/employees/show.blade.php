@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('employees.index') }}" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Home</span>
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <a href="{{ route('employees.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Trabajadores</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <span class="ml-4 text-sm font-medium text-gray-500" aria-current="page">Ficha #{{ $employee->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Ficha -->
    <div class="bg-white shadow-sm overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center bg-gray-50 border-b border-gray-200">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Información del Trabajador</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles personales y administrativos.</p>
            </div>
            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-sm font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Activo</span>
        </div>
        
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                
                <!-- Columna 1 -->
                <div class="flex items-center space-x-4 col-span-1 sm:col-span-2 mb-4">
                     <div class="h-24 w-24 rounded-full bg-clebne-100 flex items-center justify-center text-clebne-600 text-3xl font-bold">
                        <!-- Pseudo Avatar -->
                        User
                     </div>
                     <div>
                         <h2 class="text-2xl font-bold text-gray-900">{{ $employee->id_card }}</h2>
                         <p class="text-sm text-gray-500">{{ $employee->employee_type }}</p>
                     </div>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Cargo</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $employee->position->name }}</dd>
                    <dd class="text-xs text-gray-500">{{ $employee->position->direction->name }}</dd>
                </div>
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Sueldo Base</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-semibold text-green-600">Bs. {{ number_format($employee->salaryScale->amount, 2) }}</dd>
                    <dd class="text-xs text-gray-500">Tabulador: {{ $employee->salaryScale->code }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->institution_entry_date->format('d/m/Y') }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Antigüedad Total</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $employee->years_of_service }} años</dd>
                    <dd class="text-xs text-gray-500">Desde: {{ $employee->public_admin_entry_date->format('d/m/Y') }}</dd>
                </div>

                <div class="sm:col-span-2 border-t border-gray-100 pt-4 mt-2">
                   <h4 class="text-sm font-bold text-gray-900 mb-3">Conceptos Económicos (Bonos/Primas)</h4>
                   @if($employee->economicConcepts->count() > 0)
                       <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                           @foreach($employee->economicConcepts as $concept)
                               <li class="flex justify-between items-center text-sm p-2 rounded bg-gray-50">
                                   <span>{{ $concept->name }}</span>
                                   <span class="text-xs px-2 py-0.5 rounded {{ $concept->type == 'ASIGNACION' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                       {{ $concept->type }}
                                   </span>
                               </li>
                           @endforeach
                       </ul>
                   @else
                       <p class="text-sm text-gray-500 italic">No tiene conceptos adicionales asignados.</p>
                   @endif
                </div>

            </dl>
        </div>
    </div>
</div>
@endsection
