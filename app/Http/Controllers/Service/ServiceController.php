<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;

class ServiceController extends Controller
{
    use NotificationTrait;

    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAllServices();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $this->serviceService->createService($data);

        $this->notifySuccess('Service created successfully.');
        return redirect()->route('services.index');
    }

    public function edit($id)
    {
        $service = $this->serviceService->findService($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $this->serviceService->updateService($id, $data);

        $this->notifySuccess('Service updated successfully.');
        return redirect()->route('services.index');
    }

    public function destroy($id)
    {
        $this->serviceService->deleteService($id);

        $this->notifySuccess('Service deleted successfully.');
        return redirect()->route('services.index');
    }
}
