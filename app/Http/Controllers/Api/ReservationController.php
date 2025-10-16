<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\ChangeStateRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * GET /api/reservations - Listar con filtros y paginación
     */
    public function index(Request $request)
    {
        $query = Reservation::query();

        // Filtro por texto (q)
        if ($request->has('q')) {
            $query->search($request->q);
        }

        // Filtro por estado
        if ($request->has('state')) {
            $query->byState($request->state);
        }

        // Filtro por creador
        if ($request->has('created_by')) {
            $query->byCreator($request->created_by);
        }

        // Filtro geográfico (near.lat, near.lng, near.radius_km)
        if ($request->has('near.lat') && $request->has('near.lng') && $request->has('near.radius_km')) {
            $query->nearLocation(
                $request->input('near.lat'),
                $request->input('near.lng'),
                $request->input('near.radius_km')
            );
        }

        // Paginación
        $page = $request->input('page', 1);
        $size = $request->input('size', 15);
        
        $reservations = $query->paginate($size, ['*'], 'page', $page);

        return response()->json([
            'data' => $reservations->items(),
            'page' => $reservations->currentPage(),
            'size' => $reservations->perPage(),
            'total' => $reservations->total(),
            'last_page' => $reservations->lastPage(),
        ]);
    }

    /**
     * POST /api/reservations - Crear reserva
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create($request->validated());

        return response()->json([
            'message' => 'Reserva creada exitosamente',
            'data' => $reservation
        ], 201);
    }

    /**
     * GET /api/reservations/{id} - Ver detalle
     */
    public function show(Reservation $reservation)
    {
        return response()->json([
            'data' => $reservation
        ]);
    }

    /**
     * PUT /api/reservations/{id} - Editar datos básicos
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());

        return response()->json([
            'message' => 'Reserva actualizada exitosamente',
            'data' => $reservation->fresh()
        ]);
    }

    /**
     * PATCH /api/reservations/{id}/state - Cambiar estado
     */
    public function changeState(ChangeStateRequest $request, Reservation $reservation)
    {
        try {
            $reservation->changeState($request->state);

            return response()->json([
                'message' => 'Estado cambiado exitosamente',
                'data' => $reservation->fresh()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Transición de estado no válida',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * DELETE /api/reservations/{id} - Eliminar (opcional)
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'message' => 'Reserva eliminada exitosamente'
        ]);
    }
}