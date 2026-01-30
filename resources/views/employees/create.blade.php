@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ 
    activeTab: 'personal',
    salary1: '',
    updateSalary() {
        // Lógica simple para actualizar sueldo si se necesitara
    }
}">
    
    <!-- Header -->
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6 rounded-lg shadow-sm">
        <div class="sm:flex sm:items-center sm:justify-between mb-4">
            <div>
                 <h1 class="text-2xl font-bold text-gray-900">Nueva Ficha de Trabajador</h1>
                 <p class="text-sm text-gray-500">Complete la información requerida.</p>
            </div>
            <div class="flex space-x-3">
                 <a href="{{ route('employees.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">Volver al listado</a>
            </div>
        </div>

        <div class="-mb-px flex space-x-8 overflow-x-auto">
            <button type="button" @click="activeTab = 'personal'" :class="activeTab === 'personal' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                1. Datos Personales
            </button>
            <button type="button" @click="activeTab = 'organization'" :class="activeTab === 'organization' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                2. Organización y Sueldos
            </button>
            <button type="button" @click="activeTab = 'family'" :class="activeTab === 'family' ? 'border-pigene-500 text-pigene-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                3. Familia y Salud
            </button>
        </div>
    </div>
    
    @if($errors->any())
    <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-400">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-700">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @csrf

        <!-- Tab: Datos Personales -->
        <div x-show="activeTab === 'personal'" class="p-6">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                 <!-- Identificación -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Cédula</label>
                    <input type="text" name="id_card" value="{{ old('id_card') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Género</label>
                    <select name="gender" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Estado Civil</label>
                    <select name="marital_status" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        @foreach(['Soltero', 'Casado', 'Divorciado', 'Viudo', 'Concubinato'] as $st)
                            <option value="{{ $st }}" {{ old('marital_status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Nombres (1er y 2do)</label>
                    <div class="flex gap-2">
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Primer Nombre">
                        <input type="text" name="second_name" value="{{ old('second_name') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Segundo Nombre">
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Apellidos (1er y 2do)</label>
                    <div class="flex gap-2">
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Primer Apellido">
                        <input type="text" name="second_last_name" value="{{ old('second_last_name') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Segundo Apellido">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Fecha Nacimiento</label>
                    <input type="date" name="birthdate" value="{{ old('birthdate') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>

                <!-- Contacto -->
                <div class="col-span-full mt-4"><h3 class="font-semibold text-gray-900">Contacto y Académico</h3></div>
                
                <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Dirección de Habitación</label>
                    <textarea name="address" rows="2" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">{{ old('address') }}</textarea>
                </div>
                <div class="sm:col-span-3">
                     <div class="grid grid-cols-1 gap-y-4">
                         <div>
                            <label class="block text-sm font-medium text-gray-900">Teléfono</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         </div>
                     </div>
                </div>
                
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Nivel Educativo</label>
                    <select name="education_level" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         @foreach(['Primaria', 'Bachiller', 'Profesional', 'Magister', 'Doctor'] as $lvl)
                            <option value="{{ $lvl }}" {{ old('education_level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                         @endforeach
                    </select>
                </div>
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Profesión</label>
                    <input type="text" name="profession" value="{{ old('profession') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="button" @click="activeTab = 'organization'" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">Siguiente: Organización</button>
            </div>
        </div>

        <!-- Tab: Organización -->
        <div x-show="activeTab === 'organization'" class="p-6">
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Cargo</label>
                    <select name="position_id" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                        <option value="">-- Seleccione --</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="sm:col-span-3">
                     <label class="block text-sm font-medium text-gray-900">Tabulador Salarial</label>
                     <select name="salary_scale_id" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6"
                             onchange="const amount = this.options[this.selectedIndex].dataset.amount; if(amount) document.getElementById('salary_1').value = amount;">
                         <option value="" data-amount="">-- Seleccione --</option>
                         @foreach($scales as $scale)
                             <option value="{{ $scale->id }}" data-amount="{{ $scale->amount }}" {{ old('salary_scale_id') == $scale->id ? 'selected' : '' }}>
                                 {{ $scale->code }} - Bs. {{ number_format($scale->amount, 2) }}
                             </option>
                         @endforeach
                     </select>
                </div>
                
                 <div class="sm:col-span-3">
                    <label class="block text-sm font-medium text-gray-900">Tipo Personal</label>
                    <select name="employee_type" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                         @foreach($types as $t)
                             <option value="{{ $t }}" {{ old('employee_type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                         @endforeach
                    </select>
                </div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Fec. Ingreso Adm</label>
                    <input type="date" name="institution_entry_date" value="{{ old('institution_entry_date') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Años Previos (Antigüedad)</label>
                    <input type="number" name="years_prior_service" value="{{ old('years_prior_service', 0) }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                
                <div class="col-span-full border-t border-gray-100 pt-4 mb-2"><h3 class="font-semibold text-gray-900">Esquema de Sueldos</h3></div>
                
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 1 (Base/Tabulador)</label>
                    <input type="number" step="0.01" id="salary_1" name="salary_1" value="{{ old('salary_1') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 bg-gray-50">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 2</label>
                    <input type="number" step="0.01" name="salary_2" value="{{ old('salary_2') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 3</label>
                    <input type="number" step="0.01" name="salary_3" value="{{ old('salary_3') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 4</label>
                    <input type="number" step="0.01" name="salary_4" value="{{ old('salary_4') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 5</label>
                    <input type="number" step="0.01" name="salary_5" value="{{ old('salary_5') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
                 <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-900">Sueldo 6</label>
                    <input type="number" step="0.01" name="salary_6" value="{{ old('salary_6') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6">
                </div>
            </div>
             <div class="mt-6 flex justify-end">
                <button type="button" @click="activeTab = 'family'" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">Siguiente: Salud</button>
            </div>
        </div>

        <!-- Tab: Familia y Salud (Simplificado para Create) -->
        <div x-show="activeTab === 'family'" class="p-6">
            <div class="text-center mb-6 p-4 bg-yellow-50 rounded-md">
                <p class="text-sm text-yellow-800">
                    <span class="font-bold">Nota:</span> La carga familiar y las cuentas bancarias se registran 
                    <span class="underline">después de guardar</span> la ficha inicial del trabajador.
                </p>
            </div>
            
            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                 <div class="col-span-full">
                    <label class="block text-sm font-medium text-gray-900">Observaciones Médicas (Alergias, Patologías, Medicamentos)</label>
                    <textarea name="medical_observations" rows="3" class="mt-2 block w-full rounded-md border-0 py-1.5 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6" placeholder="Ej: Alérgica a penicilina, Hipertensión controlada...">{{ old('medical_observations') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">Registrar y Continuar</button>
            </div>
        </div>
        
    </form>
</div>
@endsection
