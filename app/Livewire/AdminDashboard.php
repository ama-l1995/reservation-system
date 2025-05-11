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

    public function confirmReservation($params)
    {
        $id = $params['id'] ?? null;
        if (!$id) return;

        app(ReservationService::class)->updateReservation($id, ['status' => 'confirmed']);
        $this->dispatch('toastr:success', 'Reservation confirmed successfully.');
    }


    public function cancelReservation($params)
    {
        $id = $params['id'] ?? null;
        if (!$id) return;

        try {
            app(ReservationService::class)->deleteReservation($id);
            $this->dispatch('toastr:success', 'Reservation cancelled successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toastr:error', $e->getMessage());
        }
    }

    public function render()
    {
        $serviceService = app(ServiceService::class);
        $reservationService = app(ReservationService::class);

        return view('livewire.admin-dashboard', [
            'services' => $serviceService->getAllServices(),
            'allServices' => $serviceService->getAllServices(),
            'reservations' => $reservationService->getAllReservations(),
            'livewireId' => $this->getId(),
        ])->layout('layouts.app', ['title' => 'Admin Dashboard']);
    }



}
