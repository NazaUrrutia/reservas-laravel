@extends('layouts.app')

@section('title', 'Detalle de Reserva')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Detalle de Reserva #{{ $reservation->id }}</h2>
    <div>
        <a href="{{ route('reservations.edit', $reservation) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('reservations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded ml-2">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Información básica -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Información Básica</h3>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">Nombre</label>
            <p class="text-lg">{{ $reservation->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">Creado por</label>
            <p class="text-lg">{{ $reservation->created_by }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">Dirección</label>
            <p class="text-lg">{{ $reservation->address }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">Latitud</label>
                <p class="text-lg">{{ $reservation->lat }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Longitud</label>
                <p class="text-lg">{{ $reservation->lng }}</p>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">Estado Actual</label>
            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded text-sm font-semibold">
                {{ $reservation->state }}
            </span>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-600">Fecha de Creación</label>
            <p class="text-lg">{{ $reservation->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Última Actualización</label>
            <p class="text-lg">{{ $reservation->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Cambio de estado -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Cambiar Estado</h3>

        @if(in_array($reservation->state, ['CANCELED', 'UNINSTALLED']))
            <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
                <p class="font-semibold"><i class="fas fa-lock"></i> Estado Final</p>
                <p class="text-sm mt-2">Esta reserva está en un estado final y no puede cambiar.</p>
            </div>
        @else
            <form method="POST" action="{{ route('reservations.change-state', $reservation) }}">
                @csrf
                @method('PATCH')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Nuevo Estado</label>
                    <select name="state" required class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione un estado...</option>
                        @php
                            $transitions = [
                                'RESERVED' => ['SCHEDULED', 'CANCELED'],
                                'SCHEDULED' => ['INSTALLED', 'CANCELED'],
                                'INSTALLED' => ['UNINSTALLED'],
                            ];
                            $availableStates = $transitions[$reservation->state] ?? [];
                        @endphp

                        @foreach($availableStates as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded w-full">
                    <i class="fas fa-check"></i> Cambiar Estado
                </button>
            </form>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded p-4">
                <p class="text-sm font-semibold text-blue-800 mb-2">Transiciones permitidas:</p>
                <ul class="text-sm text-blue-700 list-disc list-inside">
                    @if($reservation->state == 'RESERVED')
                        <li>RESERVED → SCHEDULED</li>
                        <li>RESERVED → CANCELED</li>
                    @elseif($reservation->state == 'SCHEDULED')
                        <li>SCHEDULED → INSTALLED</li>
                        <li>SCHEDULED → CANCELED</li>
                    @elseif($reservation->state == 'INSTALLED')
                        <li>INSTALLED → UNINSTALLED</li>
                    @endif
                </ul>
            </div>
        @endif

        <!-- Eliminar reserva -->
        <div class="mt-6 pt-6 border-t">
            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" 
                  onsubmit="return confirm('¿Está seguro de eliminar esta reserva? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded w-full">
                    <i class="fas fa-trash"></i> Eliminar Reserva
                </button>
            </form>
        </div>
    </div>
</div>
@endsection