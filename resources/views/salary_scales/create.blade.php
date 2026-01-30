@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">{{ isset($salaryScale) ? 'Editar Tabulador' : 'Nuevo Tabulador' }}</h1>
        <a href="{{ route('salary-scales.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Volver</a>
    </div>

    <form action="{{ isset($salaryScale) ? route('salary-scales.update', $salaryScale) : route('salary-scales.store') }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-6">
        @csrf
        @if(isset($salaryScale)) @method('PUT') @endif
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-medium leading-6 text-gray-900">Código / Descripción</label>
                <input type="text" name="code" value="{{ old('code', $salaryScale->code ?? '') }}" required class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                @error('code') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium leading-6 text-gray-900">Monto Base (Sueldo 1)</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $salaryScale->amount ?? '') }}" required class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                @error('amount') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">Guardar</button>
        </div>
    </form>
</div>
@endsection
