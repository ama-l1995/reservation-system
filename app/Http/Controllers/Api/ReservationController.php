<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        return response()->json($this->reservationService->getUserReservations());
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'service_id' => 'required|exists:services,id',
                'reservation_date' => 'required|date|after:now',
            ]);

            $reservation = $this->reservationService->createReservation($data);
            return response()->json($reservation, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        return response()->json($this->reservationService->findReservation($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'reservation_date' => 'required|date|after:now',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservation = $this->reservationService->updateReservation($id, $data);
        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $this->reservationService->deleteReservation($id);
        return response()->json(null, 204);
    }
}
