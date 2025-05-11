<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReservationService;

class AdminReservationController extends Controller
{
    
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function edit($id)
    {
        $reservation = $this->reservationService->findReservation($id);
        return view('admin.reservations.edit', compact('reservation'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'reservation_date' => 'required|date|after:now',
        ]);

        $this->reservationService->updateReservation($id, $data);

        return redirect()->route('admin.dashboard')->with('success', 'Reservation updated.');
    }

    public function destroy($id)
    {
        $this->reservationService->destroyReservation($id);

        return redirect()->route('admin.dashboard')->with('success', 'Reservation deleted permanently.');
    }

}
