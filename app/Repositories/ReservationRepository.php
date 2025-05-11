<?php

namespace App\Repositories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ReservationRepository
{
    protected $model;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->with(['user', 'service'])->get();
    }

    public function find($id)
    {
        return $this->model->with(['user', 'service'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $reservation = $this->find($id);
        $reservation->update($data);
        return $reservation;
    }

    public function delete($id)
    {
        $reservation = $this->find($id);
        $reservation->delete();
    }

    public function getUserReservations($userId): Collection
    {
        return $this->model->where('user_id', $userId)->with(['service'])->get();
    }

    public function checkAvailability($serviceId, $dateTime, $excludeId = null)
    {
        $query = Reservation::where('service_id', $serviceId)
            ->whereBetween('reservation_date', [
                now()->parse($dateTime)->subMinutes(10),
                now()->parse($dateTime)->addMinutes(10)
            ])
            ->where('status', '!=', 'cancelled');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    public function getFiltered($filters)
    {
        return \App\Models\Reservation::query()
            ->when($filters['service_id'] ?? null, fn($q, $v) => $q->where('service_id', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->get();
    }

}
