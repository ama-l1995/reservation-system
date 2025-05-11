<?php

namespace App\Livewire;

use App\Services\ReservationService;
use App\Services\ServiceService;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $serviceStats;
    public $reservationStats;

    protected $serviceService;
    protected $reservationService;

    public function mount()
    {
        $this->serviceService = app(ServiceService::class);
        $this->reservationService = app(ReservationService::class);
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->serviceStats = $this->serviceService->getServiceStats();
        $this->reservationStats = $this->reservationService->getReservationStats();
    }

    public function confirmReservation($id)
    {
        try {
            app(ReservationService::class)->updateReservation($id, ['status' => 'confirmed']);
            $this->dispatchBrowserEvent('toastr:success', ['message' => 'Reservation confirmed successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toastr:error', ['message' => $e->getMessage()]);
        }
    }

    public function cancelReservation($id)
    {
        try {
            app(ReservationService::class)->deleteReservation($id);
            $this->dispatchBrowserEvent('toastr:success', ['message' => 'Reservation cancelled successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('toastr:error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard', [
            'services' => $this->serviceService->getAllServices(),
            'allServices' => $this->serviceService->getAllServices(),
            'reservations' => $this->reservationService->getAllReservations(),
        ])->layout('layouts.app', ['title' => 'Admin Dashboard']);
    }

}
