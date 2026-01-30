@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Tabuladores Salariales</h1>
        <a href="{{ route('salary-scales.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-pigene-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pigene-700">
            Nuevo Tabulador
        </a>
    </div>

    @if(session('success'))
    <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400">
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    <div class="overflow-hidden bg-white shadow sm:rounded-md ring-1 ring-gray-900/5">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
                <tr>
                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Código</th>
                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Monto</th>
                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($scales as $scale)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $scale->code }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Bs. {{ number_format($scale->amount, 2) }}</td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        <a href="{{ route('salary-scales.edit', $scale) }}" class="text-pigene-600 hover:text-pigene-900 mr-4">Editar</a>
                        <form action="{{ route('salary-scales.destroy', $scale) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900">Borrar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200">
            {{ $scales->links() }}
        </div>
    </div>
</div>
@endsection
