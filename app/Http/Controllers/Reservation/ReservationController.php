<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;

class ReservationController extends Controller
{
    use NotificationTrait;
    protected $reservationService;
    protected $serviceService;

    public function __construct(ReservationService $reservationService, ServiceService $serviceService)
    {
        $this->reservationService = $reservationService;
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        try {
            $reservations = $this->reservationService->getUserReservations();
            return view('reservations.index', compact('reservations'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create($serviceId)
    {
        $service = $this->serviceService->findService($serviceId);
        return view('reservations.create', compact('service'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'service_id' => 'required|exists:services,id',
                'reservation_date' => 'required|date|after:now',
            ]);

            $this->reservationService->createReservation($data);

            $this->notifySuccess('Reservation created successfully.');
            return redirect()->route('reservations.index');
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->reservationService->deleteReservation($id);

            $this->notifySuccess('Reservation cancelled successfully.');

            return redirect()->route('reservations.index');
        } catch (\Exception $e) {
            $this->notifyError($e->getMessage());
            return back();

        }
    }
}
