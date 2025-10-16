@extends('layouts.app')

@section('title', 'Editar Reserva')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Editar Reserva #{{ $reservation->id }}</h2>
    <a href="{{ route('reservations.show', $reservation) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="bg-white p-6 rounded shadow max-w-2xl">
    <form method="POST" action="{{ route('reservations.update', $reservation) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nombre <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="name" 
                value="{{ old('name', $reservation->name) }}" 
                required 
                class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
            >
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Creado por <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="created_by" 
                value="{{ old('created_by', $reservation->created_by) }}" 
                required 
                class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('created_by') border-red-500 @enderror"
            >
            @error('created_by')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Dirección <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="address" 
                value="{{ old('address', $reservation->address) }}" 
                required 
                class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror"
            >
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Latitud <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    step="any" 
                    name="lat" 
                    value="{{ old('lat', $reservation->lat) }}" 
                    required 
                    min="-90" 
                    max="90"
                    class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('lat') border-red-500 @enderror"
                >
                @error('lat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Entre -90 y 90</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Longitud <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    step="any" 
                    name="lng" 
                    value="{{ old('lng', $reservation->lng) }}" 
                    required 
                    min="-180" 
                    max="180"
                    class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('lng') border-red-500 @enderror"
                >
                @error('lng')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Entre -180 y 180</p>
            </div>
        </div>

        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
            <p class="text-sm text-yellow-800">
                <i class="fas fa-info-circle"></i> 
                <strong>Nota:</strong> El estado actual es <strong>{{ $reservation->state }}</strong>. 
                Para cambiar el estado, use la opción en la página de detalle.
            </p>
        </div>

        <div class="flex gap-2">
            <button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded"
            >
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a 
                href="{{ route('reservations.show', $reservation) }}" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection