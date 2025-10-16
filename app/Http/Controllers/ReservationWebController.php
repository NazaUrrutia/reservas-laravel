<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Requests\ChangeStateRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

        if ($request->filled('q')) {
            $query->search($request->q);
        }

        if ($request->filled('state')) {
            $query->byState($request->state);
        }

        if ($request->filled('created_by')) {
            $query->byCreator($request->created_by);
        }

        if ($request->filled('near_lat') && $request->filled('near_lng') && $request->filled('near_radius')) {
            $query->nearLocation($request->near_lat, $request->near_lng, $request->near_radius);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('reservations.index', [
            'reservations' => $reservations,
            'states' => [
                Reservation::STATE_RESERVED,
                Reservation::STATE_SCHEDULED,
                Reservation::STATE_INSTALLED,
                Reservation::STATE_UNINSTALLED,
                Reservation::STATE_CANCELED,
            ],
            'filters' => $request->only(['q', 'state', 'created_by', 'near_lat', 'near_lng', 'near_radius'])
        ]);
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function store(StoreReservationRequest $request)
    {
        Reservation::create($request->validated());
        return redirect()->route('reservations.index')->with('success', 'Reserva creada exitosamente');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->validated());
        return redirect()->route('reservations.show', $reservation)->with('success', 'Reserva actualizada exitosamente');
    }

    public function changeState(ChangeStateRequest $request, Reservation $reservation)
    {
        try {
            $reservation->changeState($request->state);
            return back()->with('success', 'Estado cambiado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reserva eliminada exitosamente');
    }
}