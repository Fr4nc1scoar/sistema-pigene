@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-pigene-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pigene-700">
            Nuevo Operador
        </a>
    </div>

    @if(session('success'))
    <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif
    @if(session('error'))
    <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-400">
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
    @endif

    <div class="overflow-hidden bg-white shadow sm:rounded-md ring-1 ring-gray-900/5">
        <ul role="list" class="divide-y divide-gray-200">
            @foreach($users as $user)
            <li class="flex items-center justify-between px-4 py-4 sm:px-6 hover:bg-gray-50">
                <div class="flex items-center gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random" alt="">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold leading-6 text-gray-900">{{ $user->name }}</p>
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <span class="hidden sm:inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Activo</span>
                    
                    <a href="{{ route('users.edit', $user) }}" class="text-sm font-semibold text-pigene-600 hover:text-pigene-500">Editar</a>
                    
                    @if(auth()->id() !== $user->id)
                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar este usuario?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-500">Eliminar</button>
                    </form>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
        <div class="p-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
