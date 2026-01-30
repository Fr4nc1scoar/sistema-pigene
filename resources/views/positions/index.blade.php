@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Cargos</h1>
        <a href="{{ route('positions.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-pigene-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pigene-700">
            Nuevo Cargo
        </a>
    </div>

    @if(session('success'))
    <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    <div class="overflow-hidden bg-white shadow sm:rounded-md ring-1 ring-gray-900/5">
        <ul role="list" class="divide-y divide-gray-200">
            @foreach($positions as $position)
            <li class="flex items-center justify-between px-4 py-4 sm:px-6 hover:bg-gray-50">
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ $position->name }}</p>
                </div>
                <div class="flex items-center gap-x-4">
                    <a href="{{ route('positions.edit', $position) }}" class="text-sm font-semibold text-pigene-600 hover:text-pigene-500">Editar</a>
                    <form action="{{ route('positions.destroy', $position) }}" method="POST" onsubmit="return confirm('¿Seguro?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-500">Eliminar</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="p-4 border-t border-gray-200">
            {{ $positions->links() }}
        </div>
    </div>
</div>
@endsection
