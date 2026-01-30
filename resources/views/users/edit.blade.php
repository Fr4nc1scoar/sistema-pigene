@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Editar Operador: {{ $user->name }}</h1>
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Volver</a>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl p-6">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium leading-6 text-gray-900">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium leading-6 text-gray-900">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Cambiar Contraseña (Opcional)</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Nueva Contraseña</label>
                        <input type="password" name="password" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                        @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-pigene-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="rounded-md bg-pigene-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pigene-500">Actualizar Usuario</button>
        </div>
    </form>
</div>
@endsection
