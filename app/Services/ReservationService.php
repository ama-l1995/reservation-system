<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmed;
use App\Mail\ReservationCancelled;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    protected $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllReservations()
    {
        try {
            return $this->repository->all();
        } catch (\Exception $e) {
            Log::error('Failed to fetch reservations: ' . $e->getMessage());
            throw new \Exception('Unable to retrieve reservations.');
        }
    }

    public function findReservation($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            Log::error('Failed to find reservation ID ' . $id . ': ' . $e->getMessage());
            throw new \Exception('Reservation not found.');
        }
    }

    public function createReservation(array $data)
    {
        try {
            if ($this->repository->checkAvailability($data['service_id'], $data['reservation_date'])) {
                throw new \Exception('This time slot is already reserved.');
            }

            $data['user_id'] = Auth::id();
            $data['status'] = 'pending';
            $reservation = $this->repository->create($data);

            Mail::to(Auth::user()->email)->send(new ReservationConfirmed($reservation));

            return $reservation;
        } catch (\Exception $e) {
            Log::error('Failed to create reservation: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateReservation($id, array $data)
    {
        try {
            $reservation = $this->findReservation($id);

            if (isset($data['status']) && !Auth::user()->is_admin) {
                throw new \Exception('Unauthorized to update reservation status.');
            }

            if (isset($data['reservation_date']) && $this->repository->checkAvailability($reservation->service_id, $data['reservation_date'], $id)) {
                throw new \Exception('This time slot is already reserved.');
            }

            $reservation = $this->repository->update($id, $data);

            if ($reservation->status === 'cancelled') {
                Mail::to($reservation->user->email)->send(new ReservationCancelled($reservation));
            }

            return $reservation;
        } catch (\Exception $e) {
            Log::error('Failed to update reservation ID ' . $id . ': ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteReservation($id)
    {
        try {
            $reservation = $this->findReservation($id);

            if ($reservation->user_id !== Auth::id() && !Auth::user()->is_admin) {
                throw new \Exception('Unauthorized action.');
            }

            $this->repository->update($id, ['status' => 'cancelled']);

            Mail::to($reservation->user->email)->send(new ReservationCancelled($reservation));
        } catch (\Exception $e) {
            Log::error('Failed to cancel reservation ID ' . $id . ': ' . $e->getMessage());
            throw $e;
        }
    }

    public function getUserReservations()
    {

        try {
            return $this->repository->getUserReservations(Auth::id());
        } catch (\Exception $e) {
            Log::error('Failed to fetch user reservations: ' . $e->getMessage());
            throw new \Exception('Unable to retrieve user reservations.');
        }
    }

    public function getReservationStats()
    {
        try {
            return [
                'total' => $this->repository->all()->count(),
                'pending' => $this->repository->all()->where('status', 'pending')->count(),
                'confirmed' => $this->repository->all()->where('status', 'confirmed')->count(),
                'cancelled' => $this->repository->all()->where('status', 'cancelled')->count(),
                'popular_service' => $this->repository->all()->groupBy('service_id')->map->count()->sortDesc()->keys()->first(),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch reservation stats: ' . $e->getMessage());
            throw new \Exception('Unable to retrieve reservation statistics.');
        }
    }

    public function getFilteredReservations($filters)
    {
        return $this->repository->getFiltered($filters);
    }

    public function destroyReservation($id)
    {
        try {
            $reservation = $this->findReservation($id);

            if (!Auth::user()->is_admin) {
                throw new \Exception('Only admin can delete reservations permanently.');
            }

            $this->repository->delete($id);

        } catch (\Exception $e) {
            Log::error('Failed to permanently delete reservation ID ' . $id . ': ' . $e->getMessage());
            throw $e;
        }
    }


}
