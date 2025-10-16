@extends('layouts.app')
@section('content')
<h2 class="text-2xl font-bold mb-6">Nueva Reserva</h2>
<div class="bg-white p-6 rounded shadow">
    <form method="POST" action="{{ route('reservations.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">Nombre *</label>
            <input type="text" name="name" required class="w-full border px-3 py-2 rounded" value="{{ old('name') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-2">Creador *</label>
            <input type="text" name="created_by" required class="w-full border px-3 py-2 rounded" value="{{ old('created_by') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-2">Dirección *</label>
            <input type="text" name="address" required class="w-full border px-3 py-2 rounded" value="{{ old('address') }}">
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2">Latitud *</label>
                <input type="number" step="any" name="lat" required class="w-full border px-3 py-2 rounded" value="{{ old('lat') }}">
            </div>
            <div>
                <label class="block mb-2">Longitud *</label>
                <input type="number" step="any" name="lng" required class="w-full border px-3 py-2 rounded" value="{{ old('lng') }}">
            </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Crear Reserva</button>
        <a href="{{ route('reservations.index') }}" class="ml-2 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection