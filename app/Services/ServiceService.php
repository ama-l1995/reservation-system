<?php

namespace App\Services;

use App\Models\Reservation;
use App\Repositories\ServiceRepository;
use Illuminate\Support\Facades\Log;

class ServiceService
{
    protected $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllServices()
    {
        try {
            return $this->repository->all();
        } catch (\Exception $e) {
            Log::error('Failed to fetch services: ' . $e->getMessage());
            throw new \Exception('Unable to retrieve services.');
        }
    }

    public function findService($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            Log::error('Failed to find service ID ' . $id . ': ' . $e->getMessage());
            throw new \Exception('Service not found.');
        }
    }

    public function getAllFiltered($filters)
    {
        return Reservation::query()
            ->when($filters['service_id'], fn($q) => $q->where('service_id', $filters['service_id']))
            ->when($filters['status'], fn($q) => $q->where('status', $filters['status']))
            ->get();
    }

    public function createService(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            Log::error('Failed to create service: ' . $e->getMessage());
            throw new \Exception('Unable to create service.');
        }
    }

    public function updateService($id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Failed to update service ID ' . $id . ': ' . $e->getMessage());
            throw new \Exception('Unable to update service.');
        }
    }

    public function deleteService($id)
    {
        try {
            $this->repository->delete($id);
        } catch (\Exception $e) {
            Log::error('Failed to delete service ID ' . $id . ': ' . $e->getMessage());
            throw new \Exception('Unable to delete service.');
        }
    }

    public function getServiceStats()
    {
        try {
            return [
                'total' => $this->repository->all()->count(),
                'available' => $this->repository->all()->where('is_available', true)->count(),
                'unavailable' => $this->repository->all()->where('is_available', false)->count(),
            ];
        } catch (\Exception $e) {
            Log::error('Failed to fetch service stats: ' . $e->getMessage());
            throw new \Exception('Unable to retrieve service statistics.');
        }
    }
}
