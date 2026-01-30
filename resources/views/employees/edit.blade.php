@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ 
    activeTab: '{{ session('tab', 'personal') }}', 
    showFamilyModal: false, 
    showBankModal: false,
    editId: null,
    editName: '',
    editCard: '',
    editBirth: '',
    editRel: '',
    editCond: '',
    
    // Bank Edit Vars
    editBankId: null,
    editBankName: '',
    editBankNum: '',
    editBankType: '',
    editBankActive: true
}">
    
    <!-- Header with Tabs Navigation -->
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-lg shadow-sm">
        <div class="sm:flex sm:items-center sm:justify-between mb-4">
            <div>
                 <h1 class="text-2xl font-bold text-gray-900">{{ $employee->last_name }}, {{ $employee->first_name }}</h1>
                 <p class="text-sm text-gray-500">C.I. {{ $employee->id_card }} - {{ $employee->position->name }}</p>
            </div>
            <div class="flex space-x-3 items-center">
                 <a href="{{ route('employees.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm mr-4">Volver al listado</a>
                 
                 <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('¿Eliminar trabajador?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Eliminar Ficha</button>
                 </form>
            </div>
        </div>

        <div class="-mb-px flex space-x-8 overflow-x-auto">
            <button @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                1. Datos Personales
            </button>
            <button @click="activeTab = 'organization'" :class="activeTab === 'organization' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                2. Organización y Sueldos
            </button>
            <button @click="activeTab = 'family'" :class="activeTab === 'family' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                3. Familia y Salud
            </button>
        </div>
    </div>

    <!-- Feedback Message -->
    @if(session('success'))
    <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
        <div class="flex">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif
    
    @if($errors->any())
    <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-400">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-700">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Main Form Wrapper for Basic Data -->
    <form action="{{ route('employees.update', $employee) }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @csrf
        @method('PUT')

        <!-- Tab: Datos Personales -->
        <div x-show="activeTab === 'personal'" class="p-6">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                 <!-- Identificación -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Cédula</label>
                    <input type="text" name="id_card" value="{{ $employee->id_card }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Género</label>
                    <select name="gender" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        <option value="M" {{ $employee->gender == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ $employee->gender == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Estado Civil</label>
                    <select name="marital_status" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        @foreach(['Soltero', 'Casado', 'Divorciado', 'Viudo', 'Concubinato'] as $st)
                            <option value="{{ $st }}" {{ $employee->marital_status == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Nombres (1er y 2do)</label>
                    <div class="flex gap-2">
                        <input type="text" name="first_name" value="{{ $employee->first_name }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Primer Nombre">
                        <input type="text" name="second_name" value="{{ $employee->second_name }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Segundo Nombre">
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Apellidos (1er y 2do)</label>
                    <div class="flex gap-2">
                        <input type="text" name="last_name" value="{{ $employee->last_name }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Primer Apellido">
                        <input type="text" name="second_last_name" value="{{ $employee->second_last_name }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Segundo Apellido">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Fecha Nacimiento</label>
                    <input type="date" name="birthdate" value="{{ $employee->birthdate ? $employee->birthdate->format('Y-m-d') : '' }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>

                <!-- Contacto -->
                <div class="col-span-full mt-4"><h3 class="font-semibold text-gray-900">Contacto y Académico</h3></div>
                
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Nivel Educativo</label>
                    <select name="education_level" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         @foreach(['Primaria', 'Bachiller', 'Profesional', 'Magister', 'Doctor'] as $lvl)
                            <option value="{{ $lvl }}" {{ $employee->education_level == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                         @endforeach
                    </select>
                </div>
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Profesión</label>
                    <input type="text" name="profession" value="{{ $employee->profession }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Teléfono</label>
                    <input type="text" name="phone" value="{{ $employee->phone }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                 </div>
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Dirección</label>
                    <input type="text" name="address" value="{{ $employee->address }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                 </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">Guardar Cambios</button>
            </div>
        </div>

        <!-- Tab: Organización -->
        <div x-show="activeTab === 'organization'" class="p-6">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Cargo</label>
                    <select name="position_id" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Tipo Personal</label>
                    <select name="employee_type" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         @foreach($types as $t)
                             <option value="{{ $t }}" {{ $employee->employee_type == $t ? 'selected' : '' }}>{{ $t }}</option>
                         @endforeach
                    </select>
                </div>

                <div class="sm:col-span-3">
                     <label class="block text-sm font-medium text-gray-900">Tabulador Salarial</label>
                     <select name="salary_scale_id" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6"
                            onchange="const amount = this.options[this.selectedIndex].dataset.amount; if(amount) document.getElementById('salary_1').value = amount;">
                         @foreach($scales as $scale)
                             <option value="{{ $scale->id }}" data-amount="{{ $scale->amount }}" {{ $employee->salary_scale_id == $scale->id ? 'selected' : '' }}>
                                 {{ $scale->code }} - Bs. {{ number_format($scale->amount, 2) }}
                             </option>
                         @endforeach
                     </select>
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Fec. Ingreso Adm</label>
                    <input type="date" name="institution_entry_date" value="{{ $employee->institution_entry_date ? $employee->institution_entry_date->format('Y-m-d') : '' }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Años Previos (Antigüedad)</label>
                    <input type="number" name="years_prior_service" value="{{ old('years_prior_service', $employee->years_prior_service) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>

                 <div class="col-span-full border-t border-gray-100 pt-4 mb-2"><h3 class="font-semibold text-gray-900">Esquema de Sueldos</h3></div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 1 (Base/Tabulador)</label>
                    <input type="number" step="0.01" id="salary_1" name="salary_1" value="{{ old('salary_1', $employee->salary_1) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 bg-gray-50">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 2</label>
                    <input type="number" step="0.01" name="salary_2" value="{{ old('salary_2', $employee->salary_2) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 3</label>
                    <input type="number" step="0.01" name="salary_3" value="{{ old('salary_3', $employee->salary_3) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 4</label>
                    <input type="number" step="0.01" name="salary_4" value="{{ old('salary_4', $employee->salary_4) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 5</label>
                    <input type="number" step="0.01" name="salary_5" value="{{ old('salary_5', $employee->salary_5) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                 <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 6</label>
                    <input type="number" step="0.01" name="salary_6" value="{{ old('salary_6', $employee->salary_6) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
            </div>
             <div class="mt-6 flex justify-end">
                <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">Guardar Cambios</button>
            </div>
            
        </div>
    </form>

    <!-- Sub-Block for Bank Accounts inside Organization Tab scope logic (but rendered outside form due to nested forms issue) or kept inside visual tab -->
    <!-- We'll render it below or inside the div but using separate form. Logic: keep inside tab div visually -->
    <div x-show="activeTab === 'organization'" class="mt-6 p-6 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="sm:flex sm:items-center sm:justify-between mb-4">
             <h3 class="text-base font-semibold leading-7 text-gray-900">Cuentas Bancarias</h3>
             <button @click="
                showBankModal = true; 
                editBankId = null; 
                editBankName = 'Banco de Venezuela'; 
                editBankNum = ''; 
                editBankType = 'Corriente'; 
                editBankActive = true;
             " class="rounded-md bg-white border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">+ Agregar Cuenta</button>
        </div>
        
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Banco</th>
                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Cuenta</th>
                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Tipo</th>
                    <th class="py-2 text-left text-sm font-semibold text-gray-900">Estatus</th>
                    <th class="relative py-2 pl-3 pr-4 sm:pr-0"><span class="sr-only">Borrar</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($employee->bankAccounts as $acc)
                <tr>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-900">{{ $acc->bank_name }}</td>
                    <td class="whitespace-nowrap py-2 text-sm font-mono text-gray-500">{{ $acc->account_number }}</td>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $acc->type }}</td>
                    <td class="whitespace-nowrap py-2 text-sm">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $acc->is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20' }}">
                            {{ $acc->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                         <button @click="
                            editBankId = {{ $acc->id }};
                            editBankName = '{{ $acc->bank_name }}';
                            editBankNum = '{{ $acc->account_number }}';
                            editBankType = '{{ $acc->type }}';
                            editBankActive = {{ $acc->is_active ? 'true' : 'false' }};
                            showBankModal = true;
                         " class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</button>

                         <form action="{{ route('bank-accounts.destroy', $acc) }}" method="POST" class="inline">
                             @csrf @method('DELETE')
                             <button class="text-red-600 hover:text-red-900" onclick="return confirm('¿Borrar cuenta?');">Borrar</button>
                         </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Tab: Familia y Salud -->
    <div x-show="activeTab === 'family'" class="p-6 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        
        <div class="mb-8 p-4 bg-gray-50 rounded-md">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Información Médica</h4>
            <form action="{{ route('employees.update', $employee) }}" method="POST">
                @csrf @method('PUT')
                <div class="flex gap-4 items-end">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-900">Observaciones (Alergias, Patologías, Medicamentos)</label>
                        <textarea name="medical_observations" rows="2" class="mt-1 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">{{ old('medical_observations', $employee->medical_observations) }}</textarea>
                    </div>
                    <button type="submit" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Guardar Nota</button>
                </div>
            </form>
        </div>

        <div class="sm:flex sm:items-center sm:justify-between mb-4">
             <h3 class="text-base font-semibold leading-7 text-gray-900">Carga Familiar</h3>
             <button @click="showFamilyModal = true" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">+ Agregar Familiar</button>
        </div>
        
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Cédula</th>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Apellidos y Nombres</th>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Fec Nac</th>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Edad</th>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Parentesco</th>
                     <th class="py-2 text-left text-sm font-semibold text-gray-900">Condición</th>
                     <th class="relative py-2 pl-3 pr-4 sm:pr-0"><span class="sr-only">Borrar</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($employee->dependents as $dep)
                <tr>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $dep->id_card ?? 'N/A' }}</td>
                    <td class="whitespace-nowrap py-2 text-sm font-medium text-gray-900">{{ $dep->name }}</td>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $dep->birthdate->format('d/m/Y') }}</td>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $dep->birthdate->age }} años</td>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $dep->relationship }}</td>
                    <td class="whitespace-nowrap py-2 text-sm text-gray-500">{{ $dep->condition }}</td>
                    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                         <button @click="
                            editId = {{ $dep->id }}; 
                            editName = '{{ $dep->name }}'; 
                            editCard = '{{ $dep->id_card }}'; 
                            editBirth = '{{ $dep->birthdate->format('Y-m-d') }}'; 
                            editRel = '{{ $dep->relationship }}'; 
                            editCond = '{{ $dep->condition }}'; 
                            showFamilyModal = true;
                         " class="text-indigo-600 hover:text-indigo-900 mr-2">Editar</button>
                         
                         <form action="{{ route('dependents.destroy', $dep) }}" method="POST" class="inline">
                             @csrf @method('DELETE')
                             <button class="text-red-600 hover:text-red-900" onclick="return confirm('¿Borrar?');">Borrar</button>
                         </form>
                    </td>
                </tr>
                @endforeach
                 @if($employee->dependents->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500 text-sm">No hay carga familiar registrada.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- MODAL: Nuevo/Editar Carga Familiar -->
    <div x-show="showFamilyModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
             <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                  <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:p-6">
                      
                      <!-- Esta sección debe recibir datos del padre, pero x-data scope issue. 
                           Mejor usamos variables globales del tab o events.
                           Simplificación: Usar x-model en el padre (tab family) y pasarlos aquí.
                           
                           Refactor rápido: Mover x-data al wrapper principal de la vista o del tab.
                      -->
                      
                      <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                          <button type="button" @click="showFamilyModal = false; editId = null;" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                              <span class="sr-only">Cerrar</span>
                              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                          </button>
                      </div>
                      
                      <div class="sm:flex sm:items-start">
                          <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title" x-text="editId ? 'Editar Carga Familiar' : 'Nueva Carga Familiar'"></h3>
                              
                              <form :action="editId ? '/dependents/' + editId : '{{ route('dependents.store', $employee) }}'" method="POST" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                                  @csrf
                                  <input type="hidden" name="_method" :value="editId ? 'PUT' : 'POST'">
                                  
                                  <div class="sm:col-span-3">
                                      <label class="block text-sm font-medium leading-6 text-gray-900">Cédula</label>
                                      <input type="text" name="id_card" x-model="editCard" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                  </div>
                                  <div class="sm:col-span-3">
                                      <label class="block text-sm font-medium leading-6 text-gray-900">Fecha Nacimiento *</label>
                                      <input type="date" name="birthdate" x-model="editBirth" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                  </div>
                                  <div class="col-span-full">
                                      <label class="block text-sm font-medium leading-6 text-gray-900">Apellidos y Nombres *</label>
                                      <input type="text" name="name" x-model="editName" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                  </div>
                                  
                                  <div class="sm:col-span-2">
                                      <label class="block text-sm font-medium leading-6 text-gray-900">Parentesco *</label>
                                      <select name="relationship" x-model="editRel" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                          <option value="">--Seleccionar--</option>
                                          <option value="Hijo">Hijo(a)</option>
                                          <option value="Madre">Madre</option>
                                          <option value="Padre">Padre</option>
                                          <option value="Conyuge">Cónyuge</option>
                                      </select>
                                  </div>
                                  
                                  <div class="sm:col-span-2">
                                      <label class="block text-sm font-medium leading-6 text-gray-900">Condición *</label>
                                      <select name="condition" x-model="editCond" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                          <option value="Ninguna">Ninguna</option>
                                          <option value="Discapacidad">Con Discapacidad</option>
                                          <option value="Estudiante">Estudiante</option>
                                      </select>
                                  </div>

                                  <div class="col-span-full mt-4 flex justify-end gap-x-3">
                                      <button type="button" @click="showFamilyModal = false; editId = null; editName=''; editCard=''; editBirth=''; editRel=''; editCond=''" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancelar</button>
                                      <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500" x-text="editId ? 'Actualizar' : 'Guardar Familiar'"></button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
             </div>
        </div>
    </div>

    <!-- MODAL: Nueva Cuenta Bancaria -->
    <div x-show="showBankModal" class="relative z-50" aria-labelledby="modal-bank-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
             <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                  <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                      <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                          <button type="button" @click="showBankModal = false" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                              <span class="sr-only">Cerrar</span>
                              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                          </button>
                      </div>
                      
                      <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-bank-title" x-text="editBankId ? 'Editar Cuenta' : 'Agregar Cuenta Bancaria'"></h3>
                      
                      <form :action="editBankId ? '/bank-accounts/' + editBankId : '{{ route('bank-accounts.store', $employee) }}'" method="POST" class="mt-4 space-y-4">
                          @csrf
                          <input type="hidden" name="_method" :value="editBankId ? 'PUT' : 'POST'">
                          
                          <div>
                              <label class="block text-sm font-medium leading-6 text-gray-900">Banco</label>
                              <select name="bank_name" x-model="editBankName" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                  <option value="Banco de Venezuela">Banco de Venezuela</option>
                                  <option value="Banco Mercantil">Banco Mercantil</option>
                                  <option value="Banesco">Banesco</option>
                                  <option value="Banco Bicentenario">Banco Bicentenario</option>
                                  <option value="Banco del Tesoro">Banco del Tesoro</option>
                              </select>
                          </div>
                          <div>
                              <label class="block text-sm font-medium leading-6 text-gray-900">Número de Cuenta</label>
                              <input type="text" name="account_number" x-model="editBankNum" maxlength="20" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6 font-mono" placeholder="0102...">
                          </div>
                          <div class="grid grid-cols-2 gap-4">
                              <div>
                                  <label class="block text-sm font-medium leading-6 text-gray-900">Tipo</label>
                                  <select name="type" x-model="editBankType" class="block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                                      <option value="Corriente">Corriente</option>
                                      <option value="Ahorro">Ahorro</option>
                                  </select>
                              </div>
                              <div class="flex items-center pt-6">
                                  <input type="checkbox" name="is_active" value="1" id="is_active" x-model="editBankActive" class="h-4 w-4 rounded border-gray-300 text-pigene-600 focus:ring-pigene-600">
                                  <label for="is_active" class="ml-2 block text-sm text-gray-900">¿Cuenta Activa?</label>
                              </div>
                          </div>

                          <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                              <button type="submit" class="inline-flex w-full justify-center rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500 sm:col-start-2" x-text="editBankId ? 'Actualizar' : 'Guardar'"></button>
                              <button type="button" @click="showBankModal = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0">Cancelar</button>
                          </div>
                      </form>
                  </div>
             </div>
        </div>
    </div>
</div>
@endsection
