@extends('layouts.app')
@section('content')
<div class="flex justify-between mb-6">
    <h2 class="text-2xl font-bold">Reservas</h2>
    <a href="{{ route('reservations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nueva Reserva</a>
</div>

<div class="bg-white p-6 rounded shadow mb-6">
    <form method="GET" class="grid grid-cols-3 gap-4">
        <input type="text" name="q" placeholder="Buscar..." value="{{ request('q') }}" class="border px-3 py-2 rounded">
        <select name="state" class="border px-3 py-2 rounded">
            <option value="">Todos los estados</option>
            @foreach($states as $state)
                <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
    </form>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">ID</th>
                <th class="px-6 py-3 text-left">Nombre</th>
                <th class="px-6 py-3 text-left">Dirección</th>
                <th class="px-6 py-3 text-left">Creador</th>
                <th class="px-6 py-3 text-left">Estado</th>
                <th class="px-6 py-3 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
            <tr class="border-t">
                <td class="px-6 py-4">#{{ $res->id }}</td>
                <td class="px-6 py-4">{{ $res->name }}</td>
                <td class="px-6 py-4">{{ Str::limit($res->address, 30) }}</td>
                <td class="px-6 py-4">{{ $res->created_by }}</td>
                <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">{{ $res->state }}</span></td>
                <td class="px-6 py-4">
                    <a href="{{ route('reservations.show', $res) }}" class="text-blue-600">Ver</a>
                    <a href="{{ route('reservations.edit', $res) }}" class="text-yellow-600 ml-2">Editar</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center">No hay reservas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $reservations->links() }}</div>
@endsection